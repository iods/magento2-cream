<?php

namespace AHT\ModuleHelloWorld\Block;

class Newproducts extends \Magento\Framework\View\Element\Template
{
    protected $productCollection;
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection,
        array $data = []
    ) {
        $this->productCollection = $productCollection;
        parent::__construct($context, $data);
    }


    public function getProducts()
    {
        $collection = $this->productCollection->create()->addAttributeToSelect('*')
            ->setOrder('created_at')
            ->setPageSize(5);
        return $collection;
    }
}
