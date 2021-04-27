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

class SuccessOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    protected $quoteFactory;

    protected $messageManager;

    protected $layout;

    protected $cart;

    protected $logging;
    /**
     * @param \Magento\Checkout\Model\Cart          $cart
     */
    public function __construct(
        \Magento\Checkout\Model\Session\Proxy $checkoutSession,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\View\LayoutInterface $layout,
        \Magento\Checkout\Model\Cart $cart,
        Log $logging
    ) {
        $this->checkoutSession     = $checkoutSession;
        $this->quoteFactory        = $quoteFactory;
        $this->messageManager      = $messageManager;
        $this->layout              = $layout;
        $this->cart                = $cart;
        $this->logging = $logging;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->logging->addDebug(__METHOD__ . '|1|');

        if ($this->checkoutSession->getMyParcelNLBuckarooData()) {
            $this->checkoutSession->setMyParcelNLBuckarooData(null);
        }

        try {
            $this->cart->truncate()->save();
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage($exception, __('We can\'t empty the shopping cart.'));
        }
    }
}
