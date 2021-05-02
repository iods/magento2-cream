<?php

namespace AHT\ModuleHelloWorld\Model\ResourceModel\Subscription;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define the resource model & the model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('AHT\ModuleHelloWorld\Model\Subscription', 'AHT\ModuleHelloWorld\Model\ResourceModel\Subscription');
    }
}
