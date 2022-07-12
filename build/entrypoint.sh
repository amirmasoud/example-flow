#!/bin/sh
set -e

# @todo Check if database is ready
php artisan migrate --force

php artisan cache:clear

php artisan optimize:clear

php artisan route:cache

php artisan config:cache

php artisan view:cache

/usr/bin/supervisord -c /etc/supervisor/supervisord.conf

/usr/bin/supervisorctl -c /etc/supervisor/supervisord.conf reread

/usr/bin/supervisorctl -c /etc/supervisor/supervisord.conf reload
