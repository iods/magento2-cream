<?php
/**
 * Core module for supporting and extending functionality for Acuity in Magento 2
 *
 * @package   Iods_CoreUi
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Iods_CoreUi',
    __DIR__
);
