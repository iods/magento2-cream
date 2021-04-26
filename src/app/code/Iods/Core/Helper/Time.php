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

namespace Iods\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Time extends AbstractHelper
{

    public function secondsToDaysHoursMinutes($seconds)
    {
        if ($seconds) {
            $minutes = floor($seconds / 60);
        } else {
            $minutes = 0;
        }

        return $this->minutesToDaysHoursMinutes($minutes);
    }

    /**
     * Returns data so it can be used to display a countdown such as 15 days 4 hours 3 minutes */
    public function minutesToDaysHoursMinutes($minutes)
    {
        if ($minutes) {
            $days    = floor($minutes / 1440);
            $hours   = floor(($minutes - $days * 1440) / 60);
            $minutes = $minutes - ($days * 1440) - ($hours * 60);
        } else {
            $days = 0;
            $hours = 0;
            $minutes = 0;
        }

        return [
            'days'    => $days,
            'hours'   => $hours,
            'minutes' => $minutes
        ];
    }
}
