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

namespace Iods\Core\Libraries;

class Dates
{
    protected function getDatetimeNow()
    {
        $data = new \DateTime('now', new \DateTimeZone("Europe/Rome"));
        return $data;
    }

    public function getDateTimeNowStandard()
    {
        $data = $this->getDatetimeNow();
        return $data->format('Y-m-d H:i:s');
    }

    public function getDateTimeNowItalian()
    {
        $data = $this->getDatetimeNow();
        return $data->format('d/m/Y H:i:s');
    }
}
