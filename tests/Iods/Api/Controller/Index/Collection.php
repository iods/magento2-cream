<?php

namespace AHT\ModuleHelloWorld\Controller\Index;

use Zend_Debug;

class Collection extends \Magento\Framework\App\Action\Action
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
        $productCollection = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection')
            ->addAttributeToSelect([
                'name',
                'price',
                'image'
            ])

            // ->addAttributeToFilter('sku', '24-MB03')
            // ->addAttributeToFilter('entity_id', array('in' => [1, 4, 6]))
            // ->addAttributeToFilter('name', array('like' => '%mb%'))
            ->setPageSize(50, 1);
        echo ' <pre>';
        foreach ($productCollection as $product) {
            print_r($product->getData());
        }
        // echo '</pre>';
        print_r($productCollection->getSelect()->__toString());

        // return $this->_pageFactory->create();
    }
}
