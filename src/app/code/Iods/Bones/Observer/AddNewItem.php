<?php
/**
 * Description of a module goes here for Magento 2
 *
 * @package   Iods_Bones
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright © 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Bones\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AddNewItem implements ObserverInterface
{
    public function __construct()
    {

    }

    public function execute(Observer $observer)
    {
        $data = $observer->getEvent()->getQuoteItem();
        $data->setOriginalCustomPrice(100);
    }
}
