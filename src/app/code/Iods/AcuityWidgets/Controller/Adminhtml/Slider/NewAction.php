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

class NewAction extends \Dholi\Widgets\Controller\Adminhtml\Slider {
	public function execute() {
		$resultForward = $this->resultForwardFactory->create();

		return $resultForward->forward('edit');
	}
}
