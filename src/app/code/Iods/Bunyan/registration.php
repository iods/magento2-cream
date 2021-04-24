<?php
/**
 * A bigger, stronger logging framework for Magento 2
 *
 * @package   Iods_Bunyan
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright © 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Iods_Bunyan',
    __DIR__
);
