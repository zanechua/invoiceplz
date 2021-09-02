FROM node:14.17.6-alpine3.14 as base
WORKDIR /srv/http/www/invoiceneko/

# Essentials
RUN echo "UTC" > /etc/timezone
RUN apk add --no-cache \
    zip \
    unzip \
    curl \
    sqlite \
    nginx \
    supervisor \
    git \
    g++ \
    make \
    bash \
    zlib-dev \
    libpng-dev \
    autoconf \
    automake \
    libtool \
    make \
    tiff \
    jpeg \
    zlib \
    pkgconf \
    nasm \
    file \
    gcc \
    musl-dev \
    libltdl \
    python2 \
    make \
    libc6-compat

# Installing PHP
RUN apk add --no-cache php7 \
    php7-common \
    php7-fpm \
    php7-pdo \
    php7-opcache \
    php7-zip \
    php7-phar \
    php7-iconv \
    php7-cli \
    php7-curl \
    php7-openssl \
    php7-mbstring \
    php7-tokenizer \
    php7-fileinfo \
    php7-json \
    php7-xml \
    php7-xmlwriter \
    php7-simplexml \
    php7-dom \
    php7-pdo_mysql \
    php7-pdo_sqlite \
    php7-tokenizer \
    php7-pecl-redis \
    php7-bcmath \
    php7-ctype \
    php7-gd \
    php7-pcntl \
    php7-posix \
    php7-xmlreader

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# Configure supervisor
RUN mkdir -p /etc/supervisor.d/

# Configure php-fpm
RUN mkdir -p /run/php/
RUN touch /run/php/php7.0-fpm.pid
RUN touch /run/php/php7.0-fpm.sock
RUN sed -i 's~listen = 127.0.0.1:9000~listen = /run/php/php7.0-fpm.sock~g' /etc/php7/php-fpm.d/www.conf
RUN sed -i 's~;listen.owner = nobody~listen.owner = nginx~g' /etc/php7/php-fpm.d/www.conf
RUN sed -i 's~;listen.group = nobody~listen.group = nginx~g' /etc/php7/php-fpm.d/www.conf
RUN sed -i 's~;listen.mode = 0660~listen.mode = 0660~g' /etc/php7/php-fpm.d/www.conf
#RUN sed -i 's~user = nobody~user = nginx~g' /etc/php7/php-fpm.d/www.conf
#RUN sed -i 's~group = nobody~group = nginx~g' /etc/php7/php-fpm.d/www.conf

# Configure nginx
RUN echo "daemon off;" >> /etc/nginx/nginx.conf

RUN mkdir -p /run/nginx/
RUN touch /run/nginx/nginx.pid

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

# Building process
COPY --chown=nginx:nginx . .
RUN composer install
RUN yarn install

# Configure Laravel logs
RUN ln -sf /dev/stdout /srv/http/www/invoiceneko/storage/laravel.log

EXPOSE 80
CMD ["supervisord", "-c", "/etc/supervisor.d/supervisord.conf"]