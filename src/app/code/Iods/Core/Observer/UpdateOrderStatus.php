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

class UpdateOrderStatus implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Buckaroo\Magento2\Model\ConfigProvider\Account
     */
    protected $account;

    /**
     * @param \Buckaroo\Magento2\Model\ConfigProvider\Account $account
     */
    public function __construct(
        \Buckaroo\Magento2\Model\ConfigProvider\Account $account
    ) {
        $this->account = $account;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /**
         * @noinspection PhpUndefinedMethodInspection
         */
        /**
         * @var $payment \Magento\Sales\Model\Order\Payment
         */
        $payment = $observer->getPayment();

        if (strpos($payment->getMethod(), 'buckaroo_magento2') === false) {
            return;
        }

        $order = $payment->getOrder();

        $newStatus = $this->account->getOrderStatusNew($order->getStore());
        $createOrderBeforeTransaction = $this->account->getCreateOrderBeforeTransaction($order->getStore());

        if ($newStatus && !$createOrderBeforeTransaction) {
            $order->setStatus($newStatus);
        }
    }
}
