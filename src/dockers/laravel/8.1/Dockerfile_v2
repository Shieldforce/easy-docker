ARG PHP_VERSION=8.1-fpm
FROM php:${PHP_VERSION}

# Vars --------------------------------------------------
#ENV MYSQL_ROOT_PASSWORD='root'
ARG ROOT_DIR=.
ARG APP_DIR=/var/www
ARG REDIS_LIB_VERSION=5.3.7
ENV MARIADB_MYSQL_SOCKET_DIRECTORY='/var/run/mysqld'
WORKDIR $APP_DIR
# Vars --------------------------------------------------

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
COPY ${ROOT_DIR}/docker/supervisord/supervisord.conf /etc/supervisor
COPY ${ROOT_DIR}/docker/supervisord/conf /etc/supervisord.d/

# Run a cron job
#RUN apt-get install -y cron
#COPY ${ROOT_DIR}/docker/crontab/crontab.txt /etc/cron.d/crontab.txt
#RUN chmod 0644 /etc/cron.d/*
#RUN (crontab -l; echo "* * * * * php /var/www/artisan schedule:run") | crontab -

# packs
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    libpq-dev \
    libxml2-dev

# Install extensions php
RUN docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql pgsql session xml

# Hability redis
RUN apt-get install redis-server -y
RUN pecl install redis-${REDIS_LIB_VERSION} \
    && docker-php-ext-enable redis
COPY ${ROOT_DIR}/docker/redis/redis.conf /etc/redis/redis.conf

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install plus extensions php
RUN docker-php-ext-install zip iconv simplexml pcntl gd fileinfo

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

# Install mysql
RUN apt-get install --no-install-recommends -y mariadb-server
RUN apt-get install --no-install-recommends -y mariadb-client
RUN apt-get update
COPY ${ROOT_DIR}/docker/mariadb/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf
RUN chmod 0644 /etc/mysql/mariadb.conf.d/50-server.cnf
COPY ${ROOT_DIR}/docker/mariadb/create-bd.sql /docker-entrypoint-initdb.d/

#Install systemd
RUN apt-get install -y systemd

# Install Nano
RUN apt-get install -y nano

# Net
RUN apt-get install -y net-tools

EXPOSE 8008 33060 63790 9000

ENTRYPOINT ["/var/www/docker/run.sh"]

# finish dockerfile
ADD ./docker/supervisord/supervisord.conf /etc/supervisor/supervisord.conf
ADD ./docker/supervisord/conf /etc/supervisord.d/
CMD /usr/bin/supervisord -n