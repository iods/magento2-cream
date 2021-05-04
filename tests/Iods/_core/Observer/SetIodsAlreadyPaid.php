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

class SetIodsAlreadyPaid implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /**
         * @noinspection PhpUndefinedMethodInspection
         */
        /* @var $order \Magento\Sales\Model\Order */
        $order = $observer->getEvent()->getOrder();
        /**
         * @noinspection PhpUndefinedMethodInspection
         */
        /**
         * @var $quote \Magento\Quote\Model\Quote $quote
         */
        $quote = $observer->getEvent()->getQuote();

        /**
         * @noinspection PhpUndefinedMethodInspection
         */
        if ($quote->getBaseBuckarooAlreadyPaid() > 0) {
            /**
             * @noinspection PhpUndefinedMethodInspection
             */
            $order->setBuckarooAlreadyPaid($quote->getBuckarooAlreadyPaid());
            /**
             * @noinspection PhpUndefinedMethodInspection
             */
            $order->setBaseBuckarooAlreadyPaid($quote->getBaseBuckarooAlreadyPaid());
        }
    }
}
