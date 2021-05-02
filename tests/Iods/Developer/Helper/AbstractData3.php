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
use Magento\Framework\App\Helper\Context;
use Magento\Framework\DataObject;
use Magento\Framework\ObjectManagerInterface;

abstract class AbstractDatas extends AbstractHelper
{

}


function d($arg)
{
    if (is_object($arg)) {
        echo PHP_EOL . 'CLASS: ' . get_class($arg) . PHP_EOL;
        if ($arg instanceof \Magento\Framework\DB\Select) {
            var_dump($arg->__toString());
        }
        if (method_exists($arg, 'getSelect')) {
            var_dump($arg->getSelect()->__toString());
        }
        if (method_exists($arg, 'getItems')) {
            foreach ($arg->getItems() as $_item) {
                d($_item);
            }
        }
        if (method_exists($arg, 'debug')) {
            var_dump($arg->debug());
            return;
        }
        if (method_exists($arg, 'getData')) {
            var_dump($arg->getData());
            return;
        }
        if (method_exists($arg, 'toArray')) {
            var_dump($arg->toArray());
            return;
        }
    }

    // var_dump($arg);
}

function dd($arg)
{
    d($arg);
    exit;
}
