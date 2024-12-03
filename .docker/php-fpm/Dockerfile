FROM --platform=linux/x86_64 php:8.3-fpm-alpine

ARG API_SOURCE_PATH='/var/www/api'
ARG APP_ENV='dev'

RUN apk update
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    vim \
    zip \
    zlib-dev \
    libzip-dev \
    icu-dev \
    git \
    bash \
    freetype \
    freetype-dev \
    libjpeg-turbo \
    libjpeg-turbo-dev \
    freetype-dev \
    libpng \
    libpng-dev \
    libwebp-dev \
    mc \
    libxml2 \
    libxml2-dev \
    openssl \
    tzdata \
    rabbitmq-c-dev

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install exif
RUN docker-php-ext-install zip
RUN docker-php-ext-install opcache
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install simplexml


RUN rm -rf tmp/* /var/cache/apk/*

WORKDIR ${API_SOURCE_PATH}

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

CMD ["php-fpm"]

COPY entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
