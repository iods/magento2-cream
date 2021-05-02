<?php

namespace AHT\ModuleHelloWorld\Block\Adminhtml;

class Subscription extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'AHT_ModuleHelloWorld';
        $this->_controller = 'adminhtml_subscription';
        parent::_construct();
    }
}
