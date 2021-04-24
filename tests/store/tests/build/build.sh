#!/usr/bin/env bash
printf "\033[92m###### Testing that you have access to travis shell functions ...  ######\n\n\033[0m";

if ! travis_wait 1 true ; then
    echo "travis_wait is not available, please add this script to your .travis.yml with a leading dot . ./vendor/bin/travis-install-magento.sh"
    sleep 5;
    exit 1;
fi

set -e

DIR_BASE="$(dirname $(readlink -f $(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/$(basename "${BASH_SOURCE[0]}")))"
DIR_INSTANCES="$DIR_BASE/instances"

NAME=$NAME
NAME=${NAME//[-._]/}

FULL_INSTALL=${FULL_INSTALL:-1}
WITH_SAMPLE_DATA=${WITH_SAMPLE_DATA:-0}
VERSION=$VERSION
VERSION_NO_DOT=${VERSION//[-._]/}

DIR_TARGET="$DIR_INSTANCES/$NAME"
DATABASE_NAME="database-$NAME"
DATABASE_NAME=${DATABASE_NAME//[-._]/}
BASE_DOMAIN="magento-$NAME.localhost"
BASE_URL="https://$BASE_DOMAIN"

function prepare_php_and_apache() {
    if [ "$FULL_INSTALL" -eq "0" ]; then
      echo "Not configuring php-fpm and apachec as this is not a full install"
      return 0;
    fi

    printf "\033[92m###### Configuring php fpm and apache ######\n\n\033[0m";
    # fpm error logs are found here; /home/travis/.phpenv/versions/7.0.25/var/log/php-fpm.log
    sudo cp ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf.default ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf
    sudo cp $DIR_BASE/www-fpm-pool.conf ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.d/www-fpm-pool.conf
    sudo a2enmod rewrite actions fastcgi alias ssl headers proxy proxy_fcgi proxy_http expires

    echo "cgi.fix_pathinfo = 1" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
    sudo sed -i -e "s,www-data,travis,g" /etc/apache2/envvars
    sudo chown -R travis:travis /var/lib/apache2/fastcgi
    ~/.phpenv/versions/$(phpenv version-name)/sbin/php-fpm

    printf "\033[92m###### Generating self signed key ######\n\n\033[0m";
    openssl req  -nodes -new -x509  -keyout server.key -out server.cert -subj "/C=DE/ST=NRW/L=Berlin/O=My Inc/OU=DevOps/CN=$BASE_URL/emailAddress=dev@example.com"
    sudo cp server.cert /etc/ssl/certs/generated.co.crt
    sudo cp server.key /etc/ssl/private/generated.co.key
    rm server.cert server.key

    printf "\033[92m###### Preparing vhost ######\n\n\033[0m";
    sed \
    -e "s;%BASE_URL%;$BASE_DOMAIN;g" \
    -e "s;%DOCUMENT_ROOT%;$DIR_TARGET;g" \
    $DIR_BASE/vhost.conf | sudo tee -a /etc/apache2/sites-available/project.dev.conf;

    printf "\033[92m###### Updating /etc/hosts ######\n\n\033[0m";

	  if ! grep -q "127.0.0.1 $BASE_DOMAIN" "/etc/hosts"; then echo "127.0.0.1 $BASE_DOMAIN" | sudo tee -a /etc/hosts; fi;

    printf "\033[92m###### Restarting apache ######\n\n\033[0m";
    sudo a2ensite project.dev.conf
    sudo a2dissite 000-default.conf
    sudo apachectl configtest
    sudo service apache2 restart
}

function install_magento() {
    # sampledata:deploy spins up another process so we cant use -dmemory_limit
    cp ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/travis.ini ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/travis.ini.bak
    echo "memory_limit=4G" >> ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/travis.ini

    printf "\033[92m###### Creating empty database $DATABASE_NAME ######\n\n\033[0m";
    mysql -hlocalhost -uroot -e "create database if not exists $DATABASE_NAME"

    printf "\033[92m###### Composer creating $BASE_URL project at $DIR_TARGET ######\n\n\033[0m";
    composer create-project --repository=https://repo-magento-mirror.fooman.co.nz/ magento/project-community-edition=$VERSION $DIR_TARGET --no-install
    cd $DIR_TARGET
    composer config --unset repo.0
    composer config repo.foomanmirror composer https://repo-magento-mirror.fooman.co.nz/
    composer config minimum-stability dev
    composer config prefer-stable true
    composer install

    php bin/magento | head -2

    if [ "$WITH_SAMPLE_DATA" -eq "1" ]; then
        with_sampledata
    fi

    if [ "$FULL_INSTALL" -eq "1" ]; then
      printf "\033[92m###### Running installation ######\n\n\033[0m";

      travis_wait 30 php bin/magento setup:install \
          --admin-firstname=ampersand --admin-lastname=developer --admin-email=example@example.com \
          --admin-user=admin --admin-password=somepassword123 \
          --db-name=$DATABASE_NAME --db-user=root --db-host=127.0.0.1\
          --backend-frontname=admin \
          --base-url=$BASE_URL \
          --language=en_GB --currency=GBP --timezone=Europe/London \
          --use-rewrites=1

      printf "\033[92m###### Running setup upgrade ######\n\n\033[0m";

      php bin/magento setup:upgrade
    fi


    cp $DIR_BASE/install-config-mysql*.dist dev/tests/integration/etc

    mv ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/travis.ini.bak ~/.phpenv/versions/$(phpenv version-name)/etc/conf.d/travis.ini
    cd -
}

function with_sampledata() {
    printf "\033[92m###### Installing sampledata ######\n\n\033[0m";
    cd $DIR_TARGET

    # workaround because failures to install sampledata do not return a non zero exit code
    rm -f sampledata.log
    touch sampledata.log
    tail sampledata.log &

    php bin/magento sampledata:deploy > sampledata.log

    if grep -iq error sampledata.log ; then
        echo "Sampledata errors found"
        false
    fi

    rm sampledata.log
    cd -
}

function assert_alive() {
    if [ "$FULL_INSTALL" -eq "0" ]; then
      echo "Not performing any database checks as this is not a full instance"
      return 0;
    fi

    printf "\033[92m###### Asserting that you can see $BASE_URL with a 200 response ######\n\n\033[0m";
    curl -s -k --head $BASE_URL | head -1 | grep 200
    printf "\033[92m###### There are the following number of products in the database ######\n\n\033[0m";
    mysql -hlocalhost -uroot $DATABASE_NAME -e "select count(*) from catalog_product_entity;"
}

function install_elasticsearch() {
  sudo apt-get remove elasticsearch -y
  curl -O https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-7.6.2-amd64.deb
  sudo dpkg -i --force-confnew elasticsearch-7.6.2-amd64.deb
  sudo chown elasticsearch:elasticsearch /etc/default/elasticsearch
  sudo service elasticsearch restart
  sleep 5
  curl -XGET 'localhost:9200' | grep "You Know, for Search"
}

install_elasticsearch
install_magento
prepare_php_and_apache
assert_alive

set +e
