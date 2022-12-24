### Args ------------------------
ARG PHP_VERSION
ARG EXPOSE_PORT
### Args ------------------------

### Version ---------------------
FROM php:${PHP_VERSION}-fpm

# Vars --------------------------------------------------
ARG ROOT_DIR=.
ARG APP_DIR=/var/www
WORKDIR $APP_DIR
# Vars --------------------------------------------------

# enter dir
RUN cd $APP_DIR

# Permissions dir
RUN chmod 755 -R *
RUN chown -R www-data: *

# First update packegist
RUN apt-get update
RUN apt-get install -y --no-install-recommends \
    apt-utils

# Install supervisor
RUN apt-get install -y --no-install-recommends supervisor

RUN echo "tst" >> config_test.txt



COPY ${ROOT_DIR}/docker/supervisord/supervisord.conf /etc/supervisor
COPY ${ROOT_DIR}/docker/supervisord/conf /etc/supervisord.d/

# packs
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    libpq-dev \
    libxml2-dev

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install plus extensions php
RUN docker-php-ext-install zip iconv simplexml pcntl gd fileinfo \
    mysqli pdo pdo_mysql pdo_pgsql pgsql session xml

#COPY php.ini-production /usr/local/etc/php/php.ini
COPY ${ROOT_DIR}/docker/php/php.ini /usr/local/etc/php/php.ini

# Install nginx
RUN apt-get install nginx -y
COPY ${ROOT_DIR}/docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ${ROOT_DIR}/docker/nginx/sites /etc/nginx/sites-available

# Clear repositories
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install packs
RUN apt-get update && apt upgrade -y

# Install wget
RUN apt-get install -y wget

#Install systemd
RUN apt-get install -y systemd

# Install Nano
RUN apt-get install -y nano

# Net
RUN apt-get install -y net-tools

EXPOSE ${EXPOSE_PORT}

# finish dockerfile
ADD ./docker/supervisord/supervisord.conf /etc/supervisor/supervisord.conf
ADD ./docker/supervisord/conf /etc/supervisord.d/
CMD /usr/bin/supervisord -n