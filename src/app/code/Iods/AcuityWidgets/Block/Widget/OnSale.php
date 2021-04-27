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
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;

class OnSale extends AbstractProduct implements BlockInterface {

	const PRODUCTS_COUNT = 12;

	private $productCollectionFactory;

	private $itemCollection;

	protected $timezone;

	public function __construct(Context $context,
	                            StoreManagerInterface $storeManager,
	                            CollectionFactory $productCollectionFactory,
	                            array $data = []) {
		parent::__construct($context, $data);

		$this->timezone = $context->getLocaleDate();
		$this->storeManager = $storeManager;
		$this->productCollectionFactory = $productCollectionFactory;
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
			$now = date('Y-m-d H:i:s');
			$todayStartOfDayDate = $this->timezone->date()->setTime(0, 0, 0)->format('Y-m-d H:i:s');
			$todayEndOfDayDate = $this->timezone->date()->setTime(23, 59, 59)->format('Y-m-d H:i:s');

			$this->itemCollection = $this->productCollectionFactory->create();
			$this->itemCollection->addMinimalPrice()
				->addFinalPrice()
				->addTaxPercents()
				->addAttributeToSelect('*')
				->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
				->addAttributeToFilter('visibility', 4)
				->addAttributeToFilter('special_from_date', [
					'or' => [
						0 => ['date' => true, 'to' => $todayEndOfDayDate],
						1 => ['is' => new \Zend_Db_Expr('null')]
					]
				], 'left'
				)->addAttributeToFilter('special_to_date', [
					'or' => [
						0 => ['date' => true, 'from' => strtotime($now)],
						1 => ['is' => new \Zend_Db_Expr('null')]
					]
				], 'left'
				)->addAttributeToFilter([
						['attribute' => 'special_from_date', 'is' => new \Zend_Db_Expr('not null')],
						['attribute' => 'special_to_date', 'is' => new \Zend_Db_Expr('not null')]
					]
				)->addStoreFilter($this->getStoreId())
				->addAttributeToSort('special_to_date', 'desc')
				->setPageSize($this->getProductsCount());
		}

		return $this->itemCollection;
	}

	public function getAlias() {
		return md5(uniqid('', true));
	}
}