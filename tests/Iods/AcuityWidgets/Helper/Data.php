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

namespace Dholi\Widgets\Helper;

use Magento\Backend\Model\UrlInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

	protected $backendUrl;

	protected $storeManager;

	protected $categoryCollectionFactory;

	public function __construct(Context $context,
	                            CollectionFactory $categoryCollectionFactory,
	                            UrlInterface $backendUrl,
	                            StoreManagerInterface $storeManager) {
		parent::__construct($context);
		$this->backendUrl = $backendUrl;
		$this->storeManager = $storeManager;
		$this->categoryCollectionFactory = $categoryCollectionFactory;
	}

	public function getBaseUrlMedia($path = '', $secure = false) {
		return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA, $secure) . $path;
	}

	public function getCategoriesArray() {
		$categoriesArray = $this->categoryCollectionFactory->create()
			->addAttributeToSelect('name')
			->addAttributeToSort('path', 'asc')
			->load()
			->toArray();

		$categories = array();
		foreach ($categoriesArray as $categoryId => $category) {
			if (isset($category['name']) && isset($category['level'])) {
				$categories[] = array(
					'label' => $category['name'],
					'level' => $category['level'],
					'value' => $categoryId,
				);
			}
		}

		return $categories;
	}

	public function getSliderItemUrl() {
		return $this->backendUrl->getUrl('*/*/itens', ['_current' => true]);
	}
}