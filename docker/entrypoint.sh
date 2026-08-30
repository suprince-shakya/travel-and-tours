#!/bin/sh
set -e

if [ ! -f /var/www/.env ]; then
    cp /var/www/.env.example /var/www/.env
    php /var/www/artisan key:generate --force
fi

echo "DB: host=$DB_HOST db=$DB_DATABASE user=$DB_USERNAME"

mkdir -p /var/www/storage/framework/views /var/www/storage/framework/cache/data \
  /var/www/storage/framework/sessions /var/www/storage/logs /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

php /var/www/artisan migrate --force
php /var/www/artisan db:seed --force 2>/dev/null || echo "Seed skipped (table may have data)"


php -r '
$_SERVER["APP_ENV"] = "production";
require "/var/www/vendor/autoload.php";
$app = require_once "/var/www/bootstrap/app.php";
$app->bootstrapWith([Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class]);
echo "APP_KEY=" . (env("APP_KEY") ?: "EMPTY") . "\n";
echo "DB_CONNECTION=" . env("DB_CONNECTION", "not set") . "\n";
echo "DB_HOST=" . env("DB_HOST", "not set") . "\n";
echo "DB_DATABASE=" . env("DB_DATABASE", "not set") . "\n";
echo "APP_DEBUG=" . (env("APP_DEBUG") ?: "false") . "\n";
echo "Storage writable: " . (is_writable("/var/www/storage") ? "yes" : "no") . "\n";
' 2>&1 || echo "Debug info unavailable"

php-fpm -D

nginx -g "daemon off;"
