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

namespace Iods\Core\Cron;

use Iods\Core\Helper\Data;
use Iods\Core\Helper\Log;

abstract class AbstractCron
{
    protected Data $_helperData;

    protected Log $_helperLog;

    public function __construct(Data $helperData, Log $helperLog)
    {
        $this->_helperData = $helperData;
        $this->_helperLog = $helperLog;
    }
}
