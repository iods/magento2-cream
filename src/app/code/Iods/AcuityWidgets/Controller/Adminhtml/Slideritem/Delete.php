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

class Delete extends \Dholi\Widgets\Controller\Adminhtml\Slideritem {
	public function execute() {
		$itemId = $this->getRequest()->getParam(static::PARAM_CRUD_ID);
		try {
			$item = $this->itemFactory->create()->setId($itemId);
			$item->delete();
			$this->messageManager->addSuccess(__('Delete successfully!'));
		} catch (\Exception $e) {
			$this->messageManager->addError($e->getMessage());
		}

		$resultRedirect = $this->resultRedirectFactory->create();

		return $resultRedirect->setPath('*/*/');
	}
}
