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

namespace Dholi\Widgets\Ui\Component\Listing\Column;

use Magento\Framework\Filesystem;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;

class Image extends \Dholi\Widgets\Ui\Component\Listing\Column\AbstractColumn {

	const IMAGE_WIDTH = '70%';
	const IMAGE_HEIGHT = '60';
	const IMAGE_STYLE = 'display: block;margin: auto;';

	protected $storeManager;

	public function __construct(ContextInterface $context, UiComponentFactory $uiComponentFactory, Filesystem $filesystem, StoreManagerInterface $storeManager, array $components = [], array $data = []) {
		parent::__construct($context, $uiComponentFactory, $components, $data);
		$this->storeManager = $storeManager;
	}

	protected function _prepareItem(array & $item) {
		$width = $this->hasData('width') ? $this->getWidth() : self::IMAGE_WIDTH;
		//$height = $this->hasData('height') ? $this->getHeight() : self::IMAGE_HEIGHT;
		$style = $this->hasData('style') ? $this->getStyle() : self::IMAGE_STYLE;
		if (isset($item[$this->getData('name')])) {
			if ($item[$this->getData('name')]) {
				$srcImage = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $item[$this->getData('name')];
				$item[$this->getData('name')] = sprintf(
					'<img src="%s"  width="%s" style="%s" />',
					$srcImage,
					$width,
					$style
				);
			} else {
				$item[$this->getData('name')] = '';
			}
		}

		return $item;
	}
}
