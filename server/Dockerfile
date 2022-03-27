FROM php:8.1.4-fpm-alpine

WORKDIR /var/www/html

# with mysql
# RUN docker-php-ext-install pdo pdo_mysql 

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

USER 1000

