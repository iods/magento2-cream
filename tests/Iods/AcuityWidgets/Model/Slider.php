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

namespace Dholi\Widgets\Model;

use Dholi\Widgets\Model\ResourceModel\Slider\Collection;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;

class Slider extends \Magento\Framework\Model\AbstractModel {

	protected $storeId = null;

	protected $storeManager;

	public function __construct(Context $context,
	                            Registry $registry,
	                            \Dholi\Widgets\Model\ResourceModel\Slider $resource,
	                            Collection $resourceCollection,
	                            StoreManagerInterface $storeManager) {
		parent::__construct($context, $registry, $resource, $resourceCollection);
		$this->storeManager = $storeManager;

		if ($storeId = $this->storeManager->getStore()->getId()) {
			$this->storeId = $storeId;
		}
	}

	public function getStoreViewId() {
		return $this->storeId;
	}

	public function setStoreId($storeId) {
		$this->storeId = $storeId;
		return $this;
	}

	public function load($id, $field = null) {
		parent::load($id, $field);
		if ($this->getStoreViewId()) {
			$this->getStoreViewValue();
		}

		return $this;
	}

	public function getStoreViewValue($storeId = null) {
		if (!$storeId) {
			$storeId = $this->getStoreViewId();
		}
		if (!$storeId) {
			return $this;
		}

		return $this;
	}
}