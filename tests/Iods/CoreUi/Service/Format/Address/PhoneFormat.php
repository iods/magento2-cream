<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\CoreUi\Service\Format\Address;

class PhoneFormat
{
    private $startingCode = [
        'US' => '1'
    ];

    public function format($number, $country = 'US')
    {
        // format it for the form
    }

    private function isValid($number, $country)
    {
        // check if it is valid
    }

    private function formatNumber($number, $country = 'US')
    {
        // format it correctly
    }
}
