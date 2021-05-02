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

namespace Dholi\Widgets\Controller\Adminhtml\Slider;

class Itens extends \Dholi\Widgets\Controller\Adminhtml\Slider {
	public function execute() {
		$resultLayout = $this->resultLayoutFactory->create();
		$resultLayout->getLayout()->getBlock('itenslider.slider.edit.tab.itens');//->setInItem($this->getRequest()->getPost('item', null));

		return $resultLayout;
	}
}