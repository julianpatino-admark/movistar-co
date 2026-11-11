# syntax=docker/dockerfile:1

FROM alpine:3.23 AS php-base

RUN apk upgrade --no-cache \
    && apk add --no-cache \
        ca-certificates \
        php83 \
        php83-ctype \
        php83-curl \
        php83-dom \
        php83-fileinfo \
        php83-iconv \
        php83-mbstring \
        php83-opcache \
        php83-openssl \
        php83-pdo_mysql \
        php83-pdo_sqlite \
        php83-phar \
        php83-session \
        php83-simplexml \
        php83-soap \
        php83-sodium \
        php83-tokenizer \
        php83-xml \
        php83-xmlreader \
        php83-xmlwriter \
    && ln -s /usr/bin/php83 /usr/local/bin/php

FROM php-base AS php-deps

RUN apk add --no-cache git openssh-client unzip php83-zip

COPY --from=composer:2.10.3 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
COPY packages/admark/anubis ./packages/admark/anubis
COPY packages/admark/gocontact ./packages/admark/gocontact

RUN mkdir -p -m 0700 /root/.ssh

RUN --mount=type=ssh \
    --mount=type=secret,id=known_hosts,target=/root/.ssh/known_hosts,required=true \
    composer install \
        --no-dev \
        --no-interaction \
        --prefer-dist \
        --no-scripts \
        --no-autoloader


FROM node:20-alpine AS frontend

RUN apk add --no-cache ca-certificates git openssh-client

WORKDIR /app

COPY package.json package-lock.json ./
COPY vite.config.js postcss.config.js ./

RUN mkdir -p -m 0700 /root/.ssh

RUN --mount=type=ssh \
    --mount=type=secret,id=known_hosts,target=/root/.ssh/known_hosts,required=true \
    --mount=type=cache,target=/root/.npm \
    npm ci \
        --no-audit \
        --no-fund \
        --fetch-retries=5 \
        --fetch-retry-mintimeout=20000 \
        --fetch-retry-maxtimeout=120000

COPY resources ./resources
COPY public ./public
COPY fonts ./public/fonts

RUN npm run build


# ---------------------------------------------------------
# Laravel / Composer finalization
# ---------------------------------------------------------
FROM php-deps AS php-app

WORKDIR /app

COPY app ./app
COPY artisan ./artisan
COPY bootstrap ./bootstrap
COPY config ./config
COPY database ./database
COPY lang ./lang
COPY routes ./routes
COPY storage ./storage
COPY resources/views ./resources/views

RUN mkdir -p \
        bootstrap/cache \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
    && composer dump-autoload \
        --no-dev \
        --optimize \
        --no-interaction \
        --no-scripts \
    && php artisan package:discover --ansi \
    # Library lockfiles describe their standalone development dependencies.
    && find vendor/admark -name composer.lock -type f -delete


# ---------------------------------------------------------
# Production runtime
# ---------------------------------------------------------
FROM php-base AS runtime

ENV PORT=8080

RUN apk add --no-cache nginx php83-fpm tini gettext-envsubst \
    && printf '%s\n' \
        'expose_php=Off' \
        'display_errors=Off' \
        'log_errors=On' \
        'opcache.enable=1' \
        'opcache.memory_consumption=128' \
        'opcache.interned_strings_buffer=16' \
        'opcache.max_accelerated_files=10000' \
        'opcache.validate_timestamps=0' \
        'opcache.revalidate_freq=0' \
        > /etc/php83/conf.d/99-movistar.ini \
    && mkdir -p /run/nginx /run/php

COPY docker/nginx.conf.template /etc/nginx/http.d/default.conf.template
COPY docker/cloudsql-server-ca.pem /etc/ssl/cloudsql-server-ca.pem
COPY docker/check-database.php /usr/local/bin/check-database.php
COPY docker/php-fpm.conf /etc/php83/php-fpm.d/www.conf
COPY --chmod=755 docker/entrypoint.sh /usr/local/bin/movistar-entrypoint

WORKDIR /var/www/html

COPY --from=php-app /app/app ./app
COPY --from=php-app /app/bootstrap ./bootstrap
COPY --from=php-app /app/config ./config
COPY --from=php-app /app/database ./database
COPY --from=php-app /app/lang ./lang
COPY --from=php-app /app/routes ./routes
COPY --from=php-app /app/resources/views ./resources/views
COPY --from=php-app /app/storage ./storage
COPY --from=php-app /app/vendor ./vendor
COPY --from=php-app /app/artisan ./artisan
COPY --from=php-app /app/composer.json ./composer.json
COPY --from=php-app /app/composer.lock ./composer.lock

COPY --from=frontend /app/public ./public

RUN mkdir -p \
        bootstrap/cache \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
    && chown -R nginx:nginx \
        storage \
        bootstrap/cache \
    && chmod -R ug+rwX \
        storage \
        bootstrap/cache

EXPOSE 8080

ENTRYPOINT ["/sbin/tini", "--", "/usr/local/bin/movistar-entrypoint"]
