FROM php:8.0-apache
RUN apt-get update && apt-get install -y \
libonig-dev p7zip p7zip-full zip unzip zlib1g-dev libzip-dev\
&& docker-php-ext-install pdo_mysql zip

# Install Composer
COPY --from=composer/composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html



