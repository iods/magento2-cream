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

namespace Dholi\Widgets\Controller\Adminhtml\Slideritem;

class Index extends \Dholi\Widgets\Controller\Adminhtml\Slideritem {
	public function execute() {
		if ($this->getRequest()->getQuery('ajax')) {
			$resultForward = $this->resultForwardFactory->create();
			$resultForward->forward('grid');

			return $resultForward;
		}

		$resultPage = $this->resultPageFactory->create();

		return $resultPage;
	}
}
