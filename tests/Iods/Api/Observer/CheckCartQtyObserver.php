<?php

namespace AHT\ModuleHelloWorld\Observer;

class CheckCartQtyObserver implements \Magento\Framework\Event\ObserverInterface
{
    protected $_logger;
    public function __condtruct(\Psr\Log\LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($observer->getProduct()->getQty() % 2 != 0) {
            //Odd qty
            throw new \Exception('Qty must be even');
        }
    }
}
