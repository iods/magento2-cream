<?php

namespace AHT\ModuleHelloWorld\Controller\Index;

class Event extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $resultPage = $this->_pageFactory->create();
        $parameteres = [
            'product' => $this->_objectManager->create('Magento\Catalog\Model\Product')->load(50),
            'category' => $this->_objectManager->create('Magento\Catalog\Model\Product')->load(10)
        ];
        $this->_eventManager->dispatch('modulehelloworld_register_visit', $parameteres);
        return $resultPage;
    }
}
