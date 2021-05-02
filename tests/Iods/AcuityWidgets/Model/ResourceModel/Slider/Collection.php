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

namespace Dholi\Widgets\Model\ResourceModel\Slider;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

	protected $_idFieldName = 'slider_id';

	protected $storeId = null;

	protected $addedTable = [];

	protected $isLoadSliderTitle = false;

	protected function _construct() {
		$this->_init('Dholi\Widgets\Model\Slider', 'Dholi\Widgets\Model\ResourceModel\Slider');
	}

	public function __construct(EntityFactoryInterface $entityFactory,
	                            LoggerInterface $logger,
	                            FetchStrategyInterface $fetchStrategy,
	                            ManagerInterface $eventManager,
	                            StoreManagerInterface $storeManager,
	                            $connection = null,
	                            AbstractDb $resource = null) {
		parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
	}
}
