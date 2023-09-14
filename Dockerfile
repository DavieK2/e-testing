FROM ubuntu:latest

ARG DEBIAN_FRONTEND=noninteractive

RUN  apt-get update -y && apt-get install -y \ 
     software-properties-common 


RUN apt-get update && apt-get install -y \
     php8.1 \
     python3.4 \
     python3-pip \ 
     php8.1-cli \
     php8.1-common \
     php8.1-mysql \
     php8.1-zip \
     php8.1-gd \
     php8.1-mbstring \
     php8.1-curl \
     php8.1-xml \
     php8.1-bcmath 

RUN pip install pypsexec --no-cache-dir 

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./composer.* /var/www/html

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --ignore-platform-reqs --no-interaction

RUN php artisan optimize:clear && \
     php artisan cache:clear && \
     php artisan config:clear && \
     php artisan config:cache