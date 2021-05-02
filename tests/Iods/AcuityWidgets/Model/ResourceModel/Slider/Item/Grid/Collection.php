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

namespace Dholi\Widgets\Model\ResourceModel\Slider\Item\Grid;

use Dholi\Widgets\Model\Slider;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Search\AggregationInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Collection extends \Dholi\Widgets\Model\ResourceModel\Slider\Item\Collection implements SearchResultInterface {
	protected $aggregations;

	public function __construct(EntityFactoryInterface $entityFactory,
	                            LoggerInterface $logger,
	                            FetchStrategyInterface $fetchStrategy,
	                            ManagerInterface $eventManager,
	                            StoreManagerInterface $storeManager,
	                            Slider $slider,
	                            $mainTable,
	                            $eventPrefix,
	                            $eventObject,
	                            $resourceModel,
	                            $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
	                            $connection = null,
	                            AbstractDb $resource = null) {
		parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $storeManager, $slider, $connection, $resource);

		$this->_eventPrefix = $eventPrefix;
		$this->_eventObject = $eventObject;
		$this->_init($model, $resourceModel);
		$this->setMainTable($mainTable);
	}

	public function getAggregations() {
		return $this->aggregations;
	}

	public function setAggregations($aggregations) {
		$this->aggregations = $aggregations;
	}

	public function getAllIds($limit = null, $offset = null) {
		return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
	}

	public function getSearchCriteria() {
		return null;
	}

	public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null) {
		return $this;
	}

	public function getTotalCount() {
		return $this->getSize();
	}

	public function setTotalCount($totalCount) {
		return $this;
	}

	public function setItems(array $items = null) {
		return $this;
	}
}
