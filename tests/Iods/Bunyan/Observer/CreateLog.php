<?php
namespace DevMunesh\PriceChangeLog\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Stdlib\DateTime\DateTime;

use DevMunesh\PriceChangeLog\Logger\Logger;

class CreateLog implements ObserverInterface
{
    protected $_logger;
    protected $_authSession;
    protected $_date;
    
    public function __construct(
        Logger $logger,
        Session $session,
        DateTime $date
    )
    {
        $this->_logger = $logger;
        $this->_authSession = $session;
        $this->_date = $date;
    }

    public function execute(Observer $observer)
    {
        // get Product from observer
        $product = $observer->getProduct();

        // price comparison
        // if not equal -> create a log
        if($product->getFinalPrice() != $product->getOrigData('price')){
            $outputLog = "Price changed for product::  ID: " . $product->getEntityId() . "  SKU: " . $product->getSku() . "\n\t Last Price: " . $product->getOrigData('price') . "  New Price: " . $product->getFinalPrice() . "\n\t User: " . $this->getCurrentUser() . "\n\t Updation Time: " . $this->getCurrentTime();
            
            // creates log
            $this->_logger->info($outputLog);
        }
    }

    // function to get current admin user 
    public function getCurrentUser() {
        return $this->_authSession->getUser()->getUserName();
    }

    // function to get current store time
    public function getCurrentTime() {
        return $this->_date->gmtDate();
    }
}
