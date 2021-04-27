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

class PaymentMethodAvailable implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $method = $observer->getMethodInstance();
        if ($method->getCode() !== 'buckaroo_magento2_pospayment') {
            //in case if POS is available : hide all other

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $paymentHelper = $objectManager->get(\Magento\Payment\Helper\Data::class);
            $pospaymentMethodInstance = $paymentHelper->getMethodInstance('buckaroo_magento2_pospayment');

            if ($pospaymentMethodInstance->isAvailable($observer->getEvent()->getQuote())) {
                $checkResult = $observer->getEvent()->getResult();
                $checkResult->setData('is_available', false);
            }
        }
    }
}
