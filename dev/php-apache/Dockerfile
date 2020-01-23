FROM php:7.2-apache

LABEL author="Rye Miller" \
	  vendor="Darkstar" \
      version="0.1.0"

RUN \
    apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev

RUN \
    docker-php-ext-install pdo_mysql mysqli mbstring gd iconv

# COPY ./conf/config/php.ini /usr/local/etc/php/
