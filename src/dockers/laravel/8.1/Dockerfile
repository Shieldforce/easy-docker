### Args ------------------------
ARG PHP_VERSION
### Args ------------------------

### Version ---------------------
FROM php:${PHP_VERSION}-fpm

### Args ------------------------
ARG EXPOSE_PORT
ARG REDIS_PORT
ARG MYSQL_PORT
ARG SCOOB_DIR
ARG ROOT_DIR
ARG APP_DIR=/var/www
ARG REDIS_LIB_VERSION=5.3.7
ENV MARIADB_MYSQL_SOCKET_DIRECTORY='/var/run/mysqld'
### Args ------------------------

# Workdir --------------------------------------------------
WORKDIR $APP_DIR

# enter dir
RUN cd $APP_DIR

# Permissions dir
RUN chmod 755 -R *
RUN chown -R www-data: *

# Create dir for mariadb
RUN mkdir -p $MARIADB_MYSQL_SOCKET_DIRECTORY && \
    chmod 777 $MARIADB_MYSQL_SOCKET_DIRECTORY

# First update packegist
RUN apt-get update
RUN apt-get install -y --no-install-recommends \
    apt-utils

# Install supervisor
RUN apt-get install -y --no-install-recommends supervisor

COPY ${ROOT_DIR}docker_scoob/laravel/8.1/supervisord/supervisord.conf /etc/supervisor
COPY ${ROOT_DIR}docker_scoob/laravel/8.1/supervisord/conf /etc/supervisord.d/

# packs
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    libpq-dev \
    libxml2-dev

# Hability redis
RUN apt-get install redis-server -y
RUN pecl install redis-${REDIS_LIB_VERSION} \
    && docker-php-ext-enable redis
COPY ${ROOT_DIR}docker_scoob/laravel/8.1/redis/redis.conf /etc/redis/redis.conf

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install plus extensions php
RUN docker-php-ext-install zip iconv simplexml pcntl gd fileinfo \
    mysqli pdo pdo_mysql pdo_pgsql pgsql session xml

#COPY php.ini-production /usr/local/etc/php/php.ini
COPY ${ROOT_DIR}docker_scoob/laravel/8.1/php/php.ini /usr/local/etc/php/php.ini

# Install nginx
RUN apt-get install nginx -y
COPY ${ROOT_DIR}docker_scoob/laravel/8.1/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ${ROOT_DIR}docker_scoob/laravel/8.1/nginx/sites /etc/nginx/sites-available

# Clear repositories
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install packs
RUN apt-get update && apt upgrade -y

# Install wget
RUN apt-get install -y wget

# Install mysql
RUN apt-get install --no-install-recommends -y mariadb-server
RUN apt-get install --no-install-recommends -y mariadb-client
RUN apt-get update
COPY ${ROOT_DIR}docker_scoob/laravel/8.1/mariadb/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf
RUN chmod 0644 /etc/mysql/mariadb.conf.d/50-server.cnf
COPY ${ROOT_DIR}docker_scoob/laravel/8.1/mariadb/execute-sql.sql /docker-entrypoint-initdb.d/

#Install systemd
RUN apt-get install -y systemd

# Install Nano
RUN apt-get install -y nano

# Net
RUN apt-get install -y net-tools

EXPOSE ${EXPOSE_PORT} ${REDIS_PORT} ${MYSQL_PORT} 9000

ENTRYPOINT ["/var/www/docker_scoob/php/8.1/run.sh"]

# finish dockerfile
ADD ${ROOT_DIR}docker_scoob/laravel/8.1/supervisord/supervisord.conf /etc/supervisor/supervisord.conf
ADD ${ROOT_DIR}docker_scoob/laravel/8.1/supervisord/conf /etc/supervisord.d/
CMD /usr/bin/supervisord -n