FROM php:5.6-apache

# Arguments defined in docker-compose.yml
ARG user
ARG group
ARG uid


ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd exif pcntl bcmath opcache soap zip mysqli

# # Install system dependencies
# RUN apt-get update && apt-get install -y \
#     wget \
#     curl \
#     libicu-dev \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     libpng-dev \
#     libfreetype6-dev libjpeg62-turbo-dev \
#     libmagickwand-dev --no-install-recommends \
#     libzip-dev \
#     zip \
#     unzip

# RUN printf "\n" | pecl install imagick

RUN a2enmod rewrite

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# # Install PHP extension
# RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath opcache soap gd zip intl mysqli
# RUN docker-php-ext-enable imagick

# Set timezone
ENV TZ=Asia/Tehran
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt clean 

RUN usermod -u $uid $user
# This group mod has not been tested yet. remove if it breaks things.
RUN usermod -G staff $user
RUN chown -R $user:$group /var/run/apache2
RUN chown -R $user:$group /run/lock/apache2
RUN chown -R $user:$group /var/www/html

# Set working directory
WORKDIR /var/www/html

USER $user