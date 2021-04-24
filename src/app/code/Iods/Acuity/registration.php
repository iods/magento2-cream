<?php
/**
 * A theme package dedicated to learning and improving the Magento 2 UI
 *
 * @package   Iods_Acuity
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright © 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Iods_Acuity',
    __DIR__
);
