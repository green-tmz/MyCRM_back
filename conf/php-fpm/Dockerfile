ARG BASE_TAG=4.8-php8.1-alpine

# https://hub.docker.com/r/phpswoole/swoole
FROM phpswoole/swoole:$BASE_TAG

RUN apk --update add \
    build-base \
    nodejs \
    npm \
    poppler-utils \
    libxml2-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    freetype-dev \
    libwebp-dev \
    libzip-dev \
    pcre-dev \
    ${PHPIZE_DEPS} \
    postgresql-client \
    postgresql-dev && \
    pecl channel-update pecl.php.net && \
    pecl install -o -f redis && \
    docker-php-ext-configure gd \
    --prefix=/usr \
    --with-jpeg \
    --with-webp \
    --with-freetype && \
    docker-php-ext-install gd && \
    docker-php-ext-install \
    exif \
    pgsql \
    pdo \
    pdo_pgsql \
    bcmath \
    pcntl \
    xml \
    zip && \
    docker-php-ext-enable \
    redis && \
    rm -rf /tmp/pear && \
    rm /var/cache/apk/*

WORKDIR /var/www/html

EXPOSE 80
