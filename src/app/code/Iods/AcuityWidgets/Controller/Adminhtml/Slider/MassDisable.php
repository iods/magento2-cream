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

use Dholi\Widgets\Model\ResourceModel\Slider\Item\Grid\StatusesArray;
use Magento\Framework\Controller\ResultFactory;

class MassDisable extends \Dholi\Widgets\Controller\Adminhtml\AbstractAction {

	public function execute() {
		$sliderCollection = $this->_objectManager->create('Dholi\Widgets\Model\ResourceModel\Slider\Collection');
		$collection = $this->massActionFilter->getCollection($sliderCollection);
		$collectionSize = $collection->getSize();
		foreach ($collection as $item) {
			$item->setStatus(StatusesArray::STATUS_DISABLED);
			try {
				$item->save();

			} catch (\Exception $e) {
				$this->messageManager->addError($e->getMessage());
			}
		}

		$this->messageManager->addSuccess(__('A total of %1 record(s) have been disabled.', $collectionSize));

		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

		return $resultRedirect->setPath('*/*/');
	}
}
