# Этап с composer, чтобы не ставить его вручную
FROM composer:2 AS composer_stage

FROM php:8.3-fpm-alpine

# Системные пакеты для расширений PHP
RUN apk add --no-cache \
    bash git curl icu-dev libzip-dev zlib-dev \
    libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev \
    oniguruma-dev autoconf make g++ shadow \
    supervisor

# Расширения PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
 && docker-php-ext-install -j$(nproc) pdo_mysql bcmath intl gd zip exif pcntl

# Redis (через PECL)
RUN pecl install redis \
 && docker-php-ext-enable redis

# Composer
COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

# Настройки PHP (можешь править под себя)
COPY php.ini /usr/local/etc/php/conf.d/php-custom.ini

# Пользователь (чтобы права на файлы совпадали с uid/gid твоего WSL пользователя)
ARG PUID=1000
ARG PGID=1000
RUN groupmod -g ${PGID} www-data && usermod -u ${PUID} -g ${PGID} www-data
USER www-data

WORKDIR /var/www/html

# По умолчанию просто запускаем php-fpm (команду можно переопределять в compose)
CMD ["php-fpm", "-F"]
