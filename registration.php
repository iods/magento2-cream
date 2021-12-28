<?php
/**
 * Cache Rules Everything Around Magento
 *
 * @version   000.1.0
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021-2022, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Iods_Cream',
    __DIR__
);