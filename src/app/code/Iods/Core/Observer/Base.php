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

namespace Iods\Core\Observer;

use Magento\Framework\DataObject;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

class Base implements ObserverInterface
{

    protected $helperLog;
    protected $helperData;
    protected $messageManager;
    protected $event;

    public function __construct(
        DataHelper $helperData,
        LogHelper $helperLog,
        ManagerInterface $messageManager
    ) {
        $this->helperData = $helperData;
        $this->helperLog = $helperLog;
        $this->messageManager = $messageManager;
        $this->event = $this->helperData->generateClassObject(DataObject::class);
    }

    public function execute(Observer $observer)
    {
        $this->event = $this->getEvent($observer);
    }

    protected function getEvent($observer = null)
    {
        return $observer ? $observer->getEvent() : null;
    }
}
