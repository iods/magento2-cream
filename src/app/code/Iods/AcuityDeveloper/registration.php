<?php
/**
 * A toolbox for developers to build and monitor the Acuity UI on Magento 2
 *
 * @package   Iods_AcuityDeveloper
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright © 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Iods_AcuityDeveloper',
    __DIR__
);
