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

namespace Dholi\Widgets\Model\ResourceModel\Slider\Item;

use Dholi\Widgets\Model\Slider;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

	protected $_idFieldName = 'item_id';

	protected $storeId = null;

	protected $storeManager;

	protected $addedTable = [];

	protected $isLoadSliderTitle = false;

	protected $slider;

	public function __construct(EntityFactoryInterface $entityFactory,
	                            LoggerInterface $logger,
	                            FetchStrategyInterface $fetchStrategy,
	                            ManagerInterface $eventManager,
	                            StoreManagerInterface $storeManager,
	                            Slider $slider,
	                            $connection = null,
	                            AbstractDb $resource = null) {
		parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
		$this->storeManager = $storeManager;
		$this->slider = $slider;
		if ($storeId = $this->storeManager->getStore()->getId()) {
			$this->storeId = $storeId;
		}
	}

	protected function _construct() {
		$this->_init('Dholi\Widgets\Model\Item', 'Dholi\Widgets\Model\ResourceModel\Slider\Item');
	}

	public function setIsLoadSliderTitle($isLoadSliderTitle) {
		$this->isLoadSliderTitle = $isLoadSliderTitle;

		return $this;
	}

	public function getItemCollection($sliderId) {
		$itemCollection = $this->setStoreId($this->storeId)
			->addFieldToFilter('slider_id', intval($sliderId))
			->addFieldToFilter('status', \Dholi\Widgets\Model\Status::ENABLED)
			->setOrder('\'order\'', 'ASC');

		return $itemCollection;
	}

	public function getConnection() {
		return $this->getResource()->getConnection();
	}

	protected function _beforeLoad() {
		if ($this->isLoadSliderTitle()) {
			$this->joinSliderTitle();
		}

		return parent::_beforeLoad();
	}

	public function isLoadSliderTitle() {
		return $this->isLoadSliderTitle;
	}

	public function joinSliderTitle() {
		$this->getSelect()->joinLeft(['sliderTable' => $this->getTable('dholi_widgets_slider')],
			'main_table.slider_id = sliderTable.slider_id',
			['title' => 'sliderTable.title', 'slider_status' => 'sliderTable.status']
		);

		return $this;
	}

	protected function _afterLoad() {
		parent::_afterLoad();
		if ($storeId = $this->getStoreId()) {
			foreach ($this->_items as $item) {
				$item->setStoreId($storeId)->getStoreViewValue();
			}
		}

		return $this;
	}

	public function getStoreId() {
		return $this->storeId;
	}

	public function setStoreId($storeId) {
		$this->storeId = $storeId;

		return $this;
	}
}
