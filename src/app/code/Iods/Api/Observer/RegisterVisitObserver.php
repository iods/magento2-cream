<?php

namespace AHT\ModuleHelloWorld\Observer;

class RegisterVisitObserver implements \Magento\Framework\Event\ObserverInterface
{ /*@var \Psr\Log\LoggerInterface $logger */
    protected $logger;
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->logger->debug('Registed');
        $product = $observer->getProduct();
        $category = $observer->getCategory();
        $this->logger->debug(print_r($product->debug(), true));
        $this->logger->debug(print_r($category->debug(), true));
    }
}
