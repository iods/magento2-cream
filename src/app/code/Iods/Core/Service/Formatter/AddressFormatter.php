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

namespace Iods\Core\Service\Formatter;

use Magento\Sales\Api\Data\OrderAddressInterface;
use Iods\Core\Service\Formatter\Address\PhoneFormatter;
use Iods\Core\Magento2\Service\Formatter\Address\StreetFormatter;

class AddressFormatter
{
    /** @var StreetFormatter */
    private $streetFormatter;

    /** @var PhoneFormatter */
    private $phoneFormatter;

    /**
     * AddressFormatter constructor.
     *
     * @param StreetFormatter $streetFormatter
     * @param PhoneFormatter  $phoneFormatter
     */
    public function __construct(
        StreetFormatter $streetFormatter,
        PhoneFormatter $phoneFormatter
    ) {
        $this->streetFormatter = $streetFormatter;
        $this->phoneFormatter = $phoneFormatter;
    }

    /**
     * @param OrderAddressInterface $address
     *
     * @return array
     */
    public function format($address)
    {
        $formattedAddress = [
            'street' => $this->formatStreet($address->getStreet()),
            'telephone' => $this->formatTelephone($address->getTelephone(), $address->getCountryId())
        ];

        return $formattedAddress;
    }

    /**
     * @param $street
     *
     * @return array
     */
    public function formatStreet($street)
    {
        return $this->streetFormatter->format($street);
    }

    /**
     * @param $phoneNumber
     * @param $country
     *
     * @return array
     */
    public function formatTelephone($phoneNumber, $country)
    {
        return $this->phoneFormatter->format($phoneNumber, $country);
    }
}
