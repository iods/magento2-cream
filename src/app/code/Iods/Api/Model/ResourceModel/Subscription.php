<?php

namespace AHT\ModuleHelloWorld\Model\ResourceModel;


class Subscription extends \Magento\Framework\Model\ResourceModel\DB\AbstractDb
{
    public function _construct()
    {
        $this->_init('aht_helloworld_subscription', 'subscription_id');
    }
}
