FROM php:8.1-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
  libpq-dev \
  zlib1g-dev \
  libzip-dev \
  unzip \
  && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

CMD composer install && php-fpm && chown -R www-data:www-data storage

RUN composer global require laravel/installer

