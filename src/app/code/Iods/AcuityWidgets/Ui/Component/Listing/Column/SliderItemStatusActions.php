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

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class SliderItemStatusActions extends \Dholi\Widgets\Ui\Component\Listing\Column\AbstractColumn {

	protected $urlBuilder;

	public function __construct(ContextInterface $context,
	                            UiComponentFactory $uiComponentFactory,
	                            UrlInterface $urlBuilder,
	                            array $components = [],
	                            array $data = []) {
		$this->urlBuilder = $urlBuilder;
		parent::__construct($context, $uiComponentFactory, $components, $data);
	}

	protected function _prepareItem(array & $item) {
		$itemsAction = $this->getData('itemsAction');
		$indexField = $this->getData('config/indexField');

		if (isset($item[$indexField])) {
			foreach ($itemsAction as $key => $itemAction) {
				$path = isset($itemAction['path']) ? $itemAction['path'] : null;
				$itemAction['href'] = $this->urlBuilder->getUrl(
					$path,
					[$indexField => $item[$indexField]]
				);
				$item[$this->getData('name')][$key] = $itemAction;
			}
		}

		return $item;
	}
}
