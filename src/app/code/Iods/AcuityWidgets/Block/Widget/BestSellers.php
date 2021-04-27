<?php
/**
* 
* Widgets para Magento 2
* 
* @category     Dholi
* @package      Modulo Widgets
* @copyright    Copyright (c) 2021 dholi (https://www.dholi.dev)
* @version      1.0.0
* @license      https://www.dholi.dev/license/
*
*/
declare(strict_types=1);

namespace Dholi\Widgets\Block\Widget;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestSellersCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;

class BestSellers extends AbstractProduct implements BlockInterface {

	const PRODUCTS_COUNT = 12;

	private $productCollectionFactory;

	private $bestSellersCollectionFactory;

	private $itemCollection;

	public function __construct(Context $context,
	                            StoreManagerInterface $storeManager,
	                            CollectionFactory $productCollectionFactory,
	                            BestSellersCollectionFactory $bestSellersCollectionFactory,
	                            array $data = []) {
		parent::__construct($context, $data);

		$this->storeManager = $storeManager;
		$this->productCollectionFactory = $productCollectionFactory;
		$this->bestSellersCollectionFactory = $bestSellersCollectionFactory;
	}

	private function getStoreId() {
		return $this->storeManager->getStore()->getId();
	}

	protected function _toHtml() {
		if (!$this->getItems()->getSize()) {
			return '';
		}

		return parent::_toHtml();
	}

	public function getProductsCount() {
		if ($this->hasData('products_count')) {
			return $this->getData('products_count');
		}
		if (null === $this->getData('products_count')) {
			$this->setData('products_count', self::PRODUCTS_COUNT);
		}
		return $this->getData('products_count');
	}

	public function getItems() {
		if (!$this->itemCollection) {
			$productIds = [];
			$bestSellers = $this->bestSellersCollectionFactory->create()->setPeriod('month');
			foreach ($bestSellers as $product) {
				$productIds[] = $product->getProductId();
			}
			$this->itemCollection = $this->productCollectionFactory->create()->addIdFilter($productIds);
			$this->itemCollection->addMinimalPrice()
				->addFinalPrice()
				->addTaxPercents()
				->addAttributeToSelect('*')
				->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
				->addAttributeToFilter('visibility', 4)
				->addStoreFilter($this->getStoreId())->setPageSize($this->getProductsCount());
		}

		return $this->itemCollection;
	}

	public function getAlias() {
		return md5(uniqid('', true));
	}
}