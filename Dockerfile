FROM composer:2.2.3 AS composer
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --ignore-platform-reqs --no-interaction --no-scripts --prefer-dist --no-cache

FROM node:16.13.1 AS npm
WORKDIR /app
COPY ./package.json ./webpack.config.js ./tailwind.config.js ./postcss.config.js /app/
RUN npm install
COPY ./assets/ /app/assets/
COPY ./templates/ /app/templates/
RUN npm run dev

FROM php:8.2.4-apache-bullseye AS php
WORKDIR /var/www/html
COPY docker/apache.conf /etc/apache2/sites-available/apache.conf

# włączenie OPcache
RUN docker-php-ext-install opcache


# instalacja zip
RUN apt-get update && \
     apt-get install -y \
         libzip-dev \
         libicu-dev \
         zlib1g-dev \
		 libpq-dev \
		 rpl \
         && docker-php-ext-install zip intl && usermod -u 1000 www-data

RUN docker-php-ext-install intl

# instalacja GD
RUN apt-get install -y libpng-dev && \
	docker-php-ext-install gd


# instalacja PGSQL
RUN docker-php-ext-install pdo pdo_pgsql

RUN pecl install apcu-5.1.22 && docker-php-ext-enable apcu
COPY docker/ini/ /usr/local/etc/php/conf.d/
RUN cd /etc/apache2/sites-available && a2dissite 000-default.conf && a2ensite apache.conf && cd /var/www/html/ && a2enmod rewrite && a2enmod negotiation
COPY ./ /var/www/html
COPY --from=npm /app/node_modules/ /var/www/html/node_modules/
COPY --from=composer /app/vendor/ /var/www/html/vendor/
COPY --from=npm /app/public/build/ /var/www/html/public/build/
CMD apache2-foreground

## Wykonaj migracje
#RUN php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

RUN mkdir -p /public/archive \
    && mkdir -p /public/archive/genre \
    && mkdir -p /public/archive/animal

RUN mkdir -p /var/log \
    && mkdir -p /var/cache \
    && mkdir -p /var/cache/dev \
    && mkdir -p /var/cache/prod \

