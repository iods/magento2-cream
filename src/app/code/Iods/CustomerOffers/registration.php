<?php
/**
 * Extending the Iods Customer API for better discounts and offers.
 *
 * @package   Iods_CustomerOffers
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Iods_CustomerOffers',
    __DIR__
);
