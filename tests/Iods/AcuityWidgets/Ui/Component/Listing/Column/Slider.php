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

use Dholi\Widgets\Model\SliderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;

class Slider extends \Dholi\Widgets\Ui\Component\Listing\Column\AbstractColumn {

	protected $storeManager;

	protected $sliderFactory;

	public function __construct(ContextInterface $context,
	                            UiComponentFactory $uiComponentFactory,
	                            Filesystem $filesystem,
	                            StoreManagerInterface $storeManager,
	                            SliderFactory $sliderFactory,
	                            array $components = [],
	                            array $data = []) {
		parent::__construct($context, $uiComponentFactory, $components, $data);
		$this->storeManager = $storeManager;
		$this->sliderFactory = $sliderFactory;
	}

	protected function _prepareItem(array & $item) {
		$slider = $this->sliderFactory->create()->load($item[$this->getData('name')]);

		if (isset($item[$this->getData('name')])) {
			if ($item[$this->getData('name')]) {

				$item[$this->getData('name')] = sprintf('%s', $slider->getTitle());
			} else {
				$item[$this->getData('name')] = '';
			}
		}

		return $item;
	}
}
