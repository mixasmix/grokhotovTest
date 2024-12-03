#!/usr/bin/env bash
set -e

composer install

if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

exec "$@"
