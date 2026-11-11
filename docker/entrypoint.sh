#!/bin/sh
set -eu

if [ -n "${CLOUD_SQL_PRIVATE_IP:-}" ]; then
    printf '%s %s\n' "$CLOUD_SQL_PRIVATE_IP" "$DB_HOST" >> /etc/hosts
fi

if [ "$#" -gt 0 ]; then
    if [ -n "${CLOUD_SQL_PRIVATE_IP:-}" ]; then
        php /usr/local/bin/check-database.php
    fi
    exec "$@"
fi

envsubst '${PORT}' < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf
nginx -t
php-fpm83 -t
php-fpm83 --nodaemonize &
php_pid=$!
nginx -g 'daemon off;' &
nginx_pid=$!

cleanup() {
    kill -TERM "$php_pid" "$nginx_pid" 2>/dev/null || true
    wait "$php_pid" "$nginx_pid" 2>/dev/null || true
}
trap cleanup EXIT
trap 'exit 143' TERM
trap 'exit 130' INT

set +e
wait -n "$php_pid" "$nginx_pid"
exit "$?"
