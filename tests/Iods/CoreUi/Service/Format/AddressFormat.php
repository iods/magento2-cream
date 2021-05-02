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

namespace Iods\CoreUi\Service\Format;

use Iods\CoreUi\Service\Format\Address\PhoneFormat;
use Iods\CoreUi\Service\Format\Address\StreetFormat;
use Magento\Sales\Api\Data\OrderAddressInterface;

class AddressFormat
{
    /** @var PhoneFormat */
    private PhoneFormat $phoneFormatter;

    /** @var StreetFormat */
    private StreetFormat $streetFormatter;

    public function __construct(
        PhoneFormat $phoneFormat,
        StreetFormat $streetFormat
    ) {
        $this->phoneFormatter = $phoneFormat;
        $this->streetFormatter = $streetFormat;
    }

    /**
     * @param OrderAddressInterface
     * @return array
     */
    public function format(): array
    {
        return [
            'street' => $this->formatStreet(),
            'telephone' => $this->formatTelephone()
        ];
    }

    /**
     * @return array
     */
    public function formatTelephone(): array
    {
        return $this->phoneFormatter->format(3, 'US');
    }

    /**
     * @return array
     */
    public function formatStreet(): array
    {
        return $this->streetFormatter->format();
    }
}
