FROM php:8.2

RUN apt-get update && apt-get install -y \
git unzip libzip-dev libpng-dev libonig-dev libxml2-dev curl libpq-dev \
&& docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 10000

CMD sh -c "php artisan migrate:fresh --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT"
