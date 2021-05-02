<?php

namespace AHT\ModuleHelloWorld\Block;

class Landingspage extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getLandingsUrl()
    {
        return $this->getUrl('modulehelloworld');
    }

    public function getRedirectUrl()
    {
        return $this->getUrl('modulehelloworld_index_redirect');
    }
}
