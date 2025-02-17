FROM php:8.3-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apk add --no-cache \
    php-mbstring \
    php-xml \
    php-ctype \
    php-json \
    php-tokenizer \
    php-openssl \
    php-session \
    php-xmlwriter \
    php-xmlreader \
    php-simplexml \
    php-dom \
    php-xml \
    php-curl \
    php-phar \
    php-iconv \
    php-fileinfo \
    php-zip \
    php-gd \
    php-intl

WORKDIR /app

COPY composer.json .

RUN curl -sS https://getcomposer.org/installer | php

RUN php composer.phar install

COPY . .

CMD chmod -R 777 /app/var/cache /app/var/log && /app/bin/console cache:clear

EXPOSE 1010
