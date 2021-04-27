<?php
/**
 * Description of a module goes here for Magento 2
 *
 * @package   Iods_Bones
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright © 2020, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Iods_Bones',
    __DIR__
);

# ExampleModuleSkeleton module for Magento 2
This module is only a simple skeleton for further modifications.

## Installation
To install use the following composer command:

    composer require yireo-training/magento2-example-module-skeleton:dev-master

Next enable the module:

    bin/magento module:enable Yireo_ExampleModuleSkeleton
    bin/magento setup:upgrade

And flush the cache:

    bin/magento cache:clean

# Proof of concept
Run `bin/magento module:status` to see if the module has been installed.
