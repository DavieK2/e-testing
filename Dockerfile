FROM php:8.1-fpm-alpine3.18

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN docker-php-ext-install pdo pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./composer.* ./

# WORKDIR /app

COPY . .

RUN composer install --ignore-platform-reqs --no-interaction

RUN php artisan optimize:clear && \
     php artisan cache:clear && \
     php artisan config:clear && \
     php artisan config:cache