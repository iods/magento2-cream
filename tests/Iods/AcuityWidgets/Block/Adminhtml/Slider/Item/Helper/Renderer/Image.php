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

namespace Dholi\Widgets\Block\Adminhtml\Slider\Item\Helper\Renderer;

use Dholi\Widgets\Model\ItemFactory;
use Magento\Backend\Block\Context;
use Magento\Framework\DataObject;
use Magento\Store\Model\StoreManagerInterface;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer {
	protected $storeManager;

	protected $itemFactory;

	public function __construct(Context $context, StoreManagerInterface $storeManager, ItemFactory $itemFactory, array $data = []) {
		parent::__construct($context, $data);
		$this->storeManager = $storeManager;
		$this->itemFactory = $itemFactory;
	}

	public function render(DataObject $row) {
		$storeId = $this->getRequest()->getParam('store');
		$item = $this->itemFactory->create()->setStoreId($storeId)->load($row->getId());
		$srcImage = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $item->getImage();

		return '<image width="150px" src ="' . $srcImage . '" alt="' . $item->getImage() . '" >';
	}
}
