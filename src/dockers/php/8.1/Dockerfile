### Args ------------------------
ARG PHP_VERSION
### Args ------------------------

### Version ---------------------
FROM php:${PHP_VERSION}-fpm

### Args ------------------------
ARG EXPOSE_PORT
ARG SCOOB_DIR
ARG ROOT_DIR
ARG APP_DIR=/var/www
### Args ------------------------

# Workdir --------------------------------------------------
WORKDIR $APP_DIR

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

COPY ${SCOOB_DIR}/docker/supervisord/supervisord.conf /etc/supervisor
COPY ${SCOOB_DIR}/docker/supervisord/conf /etc/supervisord.d/

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
COPY ${SCOOB_DIR}/docker/php/php.ini /usr/local/etc/php/php.ini

# Install nginx
RUN apt-get install nginx -y
COPY ${SCOOB_DIR}/docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ${SCOOB_DIR}/docker/nginx/sites /etc/nginx/sites-available

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

# Copy docker configs local
COPY ${SCOOB_DIR}/docker/run.sh ${ROOT_DIR}docker/run.sh
RUN chmod +x ${ROOT_DIR}docker/run.sh

EXPOSE ${EXPOSE_PORT}

ENTRYPOINT ["${ROOT_DIR}'docker/run.sh'"]

# finish dockerfile
ADD ${SCOOB_DIR}/docker/supervisord/supervisord.conf /etc/supervisor/supervisord.conf
ADD ${SCOOB_DIR}/docker/supervisord/conf /etc/supervisord.d/
CMD /usr/bin/supervisord -n