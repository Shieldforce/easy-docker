### Args ------------------------
ARG PHP_VERSION
ARG EXPOSE_PORT
### Args ------------------------

### Version ---------------------
FROM php:${PHP_VERSION}-fpm

### IMplements --------------------------------------------------
# Apache 2.4 + PHP-${PHP_VERSION}-FPM
RUN apt-get update \
    # Tools
    && apt-get -y --no-install-recommends install \
        curl \
        ca-certificates \
        nano \
        zip \
        unzip \
        git \
    # Supervisor
    && apt-get -y --no-install-recommends install \
        supervisor \
    # Install Apache + PHP
    && apt-get -y --no-install-recommends install \
        apache2 \
        docker-php-ext-install xml gd mbstring bcmath zip memcache curl php-xdebug \
    # Enable Extension + PHP
    && docker-php-ext-enable xml gd mbstring bcmath zip memcache curl php-xdebug \
    # Configure Apache + PHP
    && a2enmod proxy \
    && a2enmod proxy_fcgi \
    && a2enmod rewrite \
    # Clean
    && rm -rf /var/lib/apt/lists/*


# Supervisor
RUN mkdir -p /run/php/
COPY ./supervisord/supervisord.conf /etc/supervisor/supervisord.conf
COPY ./supervisord/conf/ /etc/supervisor/conf.d/

# Apache Configuration
COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# PHP Configuration
COPY ./php/fpm/php.ini /etc/php/${PHP_VERSION}/fpm/php.ini
COPY ./php/fpm/pool.d/www.conf /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf
COPY ./php/fpm/xdebug.ini /etc/php/${PHP_VERSION}/mods-available/xdebug.ini

COPY ./scripts/start.sh /start.sh
RUN chmod 755 /start.sh
### IMplements --------------------------------------------------

### Port Expose ----------------
EXPOSE ${EXPOSE_PORT}

CMD ["/bin/bash", "/start.sh"]
