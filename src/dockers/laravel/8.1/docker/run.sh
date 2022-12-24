#!/bin/sh
# shellcheck disable=SC2164

cd /var/www

composer update

chmod -R 775 /var/www/public
chmod -R 777 /var/www/bootstrap
chmod -R 777 /var/www/storage

php artisan migrate --seed

exec "$@"
