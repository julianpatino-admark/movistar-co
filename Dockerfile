# syntax=docker/dockerfile:1

FROM php:8.3.36-cli-trixie AS php-deps

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        git \
        openssh-client \
        unzip \
        libxml2-dev \
    && docker-php-ext-install -j"$(nproc)" \
        dom \
        pdo_mysql \
        soap \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2.10.3 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
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


FROM node:20-bookworm-slim AS frontend

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        git \
        openssh-client \
    && rm -rf /var/lib/apt/lists/*

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
    && php artisan package:discover --ansi


# ---------------------------------------------------------
# Production runtime
# ---------------------------------------------------------
FROM php:8.3.36-apache-trixie AS runtime

ENV PORT=8080

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        libxml2-dev \
        libcurl4-openssl-dev \
    && docker-php-ext-install -j"$(nproc)" \
        dom \
        pdo_mysql \
        soap \
        curl \
        opcache \
    && a2enmod rewrite headers \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && rm -rf /var/lib/apt/lists/*

RUN printf '%s\n' \
    'opcache.enable=1' \
    'opcache.memory_consumption=128' \
    'opcache.interned_strings_buffer=16' \
    'opcache.max_accelerated_files=10000' \
    'opcache.validate_timestamps=0' \
    'opcache.revalidate_freq=0' \
    > "$PHP_INI_DIR/conf.d/opcache-recommended.ini"

RUN printf '%s\n' \
        'ServerName localhost' \
        > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

RUN printf '%s\n' \
        'Listen ${PORT}' \
        > /etc/apache2/ports.conf \
    && printf '%s\n' \
        '<VirtualHost *:${PORT}>' \
        '    ServerName localhost' \
        '    DocumentRoot /var/www/html/public' \
        '' \
        '    <Directory /var/www/html/public>' \
        '        Options -Indexes +FollowSymLinks' \
        '        AllowOverride All' \
        '        Require all granted' \
        '    </Directory>' \
        '' \
        '    ErrorLog /proc/self/fd/2' \
        '    CustomLog /proc/self/fd/1 combined' \
        '</VirtualHost>' \
        > /etc/apache2/sites-available/000-default.conf

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

COPY --from=frontend /app/public ./public

RUN mkdir -p \
        bootstrap/cache \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
    && chown -R www-data:www-data \
        storage \
        bootstrap/cache \
    && chmod -R ug+rwX \
        storage \
        bootstrap/cache

EXPOSE 8080

CMD ["apache2-foreground"]