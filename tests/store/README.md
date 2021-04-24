Docker Stack
============

Sandbox of Docker development locally. Language and platform agnostic.


License
-------

This project/code is released under [the MIT license](https://github.com/iods/docker-stack/LICENSE).


Copyright
---------

(c) 2020 Rye Miller. All Rights Reserved.

# Magento Lite

After reading this [article](https://www.integer-net.com/removing-unused-core-modules-from-magento-2-the-right-way/) we have added our new repository for replace useless and unused module added in the latest Magento 2 versions. In this way we could

## Installation

In order to install this module, execute this command:

```bash
composer config repositories.shinesoftware-magento-lite vcs https://github.com/shinesoftware/magento-lite.git
```

and then:

```bash
composer require shinesoftware/magento-lite:[VERSION]
```

The versions are published here: https://github.com/shinesoftware/magento-lite/releases


# ampersand/travis-vanilla-magento

[![Build Status](https://travis-ci.org/AmpersandHQ/travis-vanilla-magento.svg?branch=master)](https://travis-ci.org/AmpersandHQ/travis-vanilla-magento)

This script helps bootstrap a magento2 instance in travis for running tests against.

Uses https://store.fooman.co.nz/blog/no-authentication-needed-magento-2-mirror.html

## Caveats

- It generates a cert on the fly so you'll need to suppress SSL errors. Any PRs to fix this would be welcomed.

## Example

```
composer require --dev ampersand/travis-vanilla-magento
```

You call the script from your `.travis.yml` and it will set up a magento instance for you to run tests against.

Look at [this repositories `.travis.yml`](https://github.com/AmpersandHQ/magento2-disable-stock-reservation/blob/master/.travis.yml) to see which dependencies are needed

### Install a specific version

`VERSION=2.3.3 NAME=TESTONE . ./vendor/bin/travis-install-magento.sh`

This would generate
- https://magento-TESTONE.localhost
- a database accessible at `mysql -uroot -h127.0.0.1 databaseTESTONE`
- To add sample data set the flag when installing

    ```
    VERSION=2.3.3 NAME=TESTONE WITH_SAMPLE_DATA=1 . ./vendor/bin/travis-install-magento.sh
    ```

### Install latest version

`NAME=TESTTWO . ./vendor/bin/travis-install-magento.sh`

This would generate
- https://magento-TESTTWO.localhost
- a database accessible at `mysql -uroot -h127.0.0.1 databaseTESTTWO`
- To add sample data set the flag when installing

    ```
    NAME=TESTTWO WITH_SAMPLE_DATA=1 . ./vendor/bin/travis-install-magento.sh
    ```
