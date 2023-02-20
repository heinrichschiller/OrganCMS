# Use ubuntu:22.04 as the base image
FROM ubuntu:22.04

ARG DEBIAN_FRONTEND=noninteractive

# Set timezone to Europe/Berlin
ENV TZ="Europe/Berlin"

# Install Apache, PHP and Git and set the working directory
RUN apt-get update && \
    apt-get install -y apache2 \
        git \
        curl \
        sqlite3 \
        unzip \
        php \
        php-cli \
        php-curl \
        php8.1-dev \
        php-apcu \
        php-gd \
        php-intl \
        php-mbstring \
        php-pear \
        php-pdo \
        php-sqlite3 \
        php-simplexml \
        php-zip \
        libapache2-mod-php \
        libssl-dev \
        libmcrypt-dev \
        libicu-dev \
        libpq-dev \
        libjpeg-dev  \
        libpng-dev \
        zlib1g-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Install XDebug
RUN pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /etc/php/8.1/apache2/conf.d/30-xdebug.ini \
    && echo 'xdebug.remote_autostart=0' >> /etc/php/8.1/apache2/conf.d/30-xdebug.ini \
    && echo 'xdebug.remote_enable=1' >> /etc/php/8.1/apache2/conf.d/30-xdebug.ini \
    && echo 'xdebug.remote_host=host.docker.internal' >> /etc/php/8.1/apache2/conf.d/30-xdebug.ini \
    && echo 'xdebug.remote_port=9000' >>  /etc/php/8.1/apache2/conf.d/30-xdebug.ini \
    && echo 'xdebug.remote_cookie_expire_time=36000' >> /etc/php/8.1/apache2/conf.d/30-xdebug.ini \
    && echo 'xdebug.mode=develop,debug' >> /etc/php/8.1/apache2/conf.d/30-xdebug.ini \
    && echo 'xdebug.client_host=host.docker.internal' >> /etc/php/8.1/apache2/conf.d/30-xdebug.ini \
    && echo 'xdebug.start_with_request=yes' >> /etc/php/8.1/apache2/conf.d/30-xdebug.ini 

RUN a2enmod rewrite

# Allow .htaccess files to be used
RUN sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copy the index.php file to the working directory
COPY . /var/www/html

# 
RUN chown www-data.www-data -R /data
RUN chown www-data.www-data -R /var
RUN chown www-data.www-data -R /public/assets

# Remove ubuntu index.html
RUN rm /var/www/html/index.html

# Start Apache when the container starts
CMD ["apachectl", "-D", "FOREGROUND"]
