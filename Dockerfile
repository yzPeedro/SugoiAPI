FROM php:8.3-alpine

RUN apk add --no-cache \
    php-mbstring \
    php-xml \
    php-ctype \
    php-json \
    php-tokenizer \
    php-openssl \
    php-pdo \
    php-pdo_mysql \
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

COPY composer.json composer.phar

RUN php composer.phar install --ignore-platform-reqs

COPY . .

CMD chmod -R 777 /app/var/cache /app/var/log && /app/bin/console cache:clear

EXPOSE 1010
