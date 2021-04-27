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

namespace Iods\Core\Service\Formatter\Address;

class StreetFormatter
{
    /**
     * @param array $street
     *
     * @return array
     */
    public function format($street)
    {
        $street = $this->prepareStreetString($street);

        $format = [
            'house_number'    => '',
            'number_addition' => '',
            'street'          => $street
        ];

        $match = preg_match('#^(.*?)([0-9]+)(.*)#s', $street, $matches);

        if ($match) {
            $format = $this->formatStreet($matches);
        }

        return $format;
    }

    /**
     * Street is always an array since it is parsed with two field objects.
     * Nondeless it could be that only the first field is parsed to the array
     *
     * @param array $street
     *
     * @return string
     */
    private function prepareStreetString($street)
    {
        $newStreet = $street[0];

        if (!empty($street[1])) {
            $newStreet .= ' ' . $street[1];
        }

        if (!empty($street[2])) {
            $newStreet .= ' ' . $street[2];
        }

        return $newStreet;
    }

    /**
     * @param array $matches
     *
     * @return array
     */
    private function formatStreet($matches)
    {
        $format = [
            'house_number'    => trim($matches[2]),
            'number_addition' => '',
            'street'          => trim($matches[3]),
        ];

        if (!('' == $matches[1])) {
            $format['street']          = trim($matches[1]);
            $format['number_addition'] = trim($matches[3]);
        }

        return $format;
    }
}
