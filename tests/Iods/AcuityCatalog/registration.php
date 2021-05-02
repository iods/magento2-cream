<?php
/**
 * Product and category tweaks on top of Acuity for Magento 2
 *
 * @package   Iods_AcuityCatalog
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright © 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Iods_AcuityCatalog',
    __DIR__
);
