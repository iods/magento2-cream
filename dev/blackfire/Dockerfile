FROM php:7.2-fpm

LABEL author="Rye Miller" \
	  vendor="Darkstar" \
      version="0.1.0" \

RUN \
    apt-get update && apt-get install -y \
    wget \
    gnupg2

RUN \
    docker-php-ext-install pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN wget -q -O - https://packages.blackfire.io/gpg.key | apt-key add -
RUN echo "deb http://packages.blackfire.io/debian any main" | tee /etc/apt/sources.list.d/blackfire.list \
RUN apt-get update && apt-get install -y blackfire-agent blackfire-php
