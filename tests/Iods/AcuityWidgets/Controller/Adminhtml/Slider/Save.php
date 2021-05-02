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

use Dholi\Widgets\Model\Slider;

class Save extends \Dholi\Widgets\Controller\Adminhtml\Slider {

	public function execute() {
		$resultRedirect = $this->resultRedirectFactory->create();
		$formPostValues = $this->getRequest()->getPostValue();

		if (isset($formPostValues['slider'])) {
			$sliderData = $formPostValues['slider'];
			$sliderId = isset($sliderData['slider_id']) ? $sliderData['slider_id'] : null;

			$model = $this->sliderFactory->create();
			$model->load($sliderId);
			$model->setData($sliderData);

			try {
				$model->save();

				if (isset($formPostValues['slider_item'])) {
					$itemGridSerializedInputData = $this->jsHelper->decodeGridSerializedInput($formPostValues['slider_item']);
					$itemIds = [];
					foreach ($itemGridSerializedInputData as $key => $value) {
						$itemIds[] = $key;
						$itemOrders[] = $value['order_item_slider'];
					}

					$unSelecteds = $this->itemCollectionFactory
						->create()
						->setStoreId(null)
						->addFieldToFilter('slider_id', $model->getId());
					if (count($itemIds)) {
						$unSelecteds->addFieldToFilter('item_id', array('nin' => $itemIds));
					}

					foreach ($unSelecteds as $item) {
						$item->setSliderId(0)
							->setStoreId(null)
							->setOrderItem(0)->save();
					}

					$selectItem = $this->itemCollectionFactory
						->create()
						->setStoreId(null)
						->addFieldToFilter('item_id', array('in' => $itemIds));
					$i = -1;
					foreach ($selectItem as $item) {
						$item->setSliderId($model->getId())
							->setStoreId(null)
							->setOrderItem($itemOrders[++$i])->save();
					}
				}

				$this->messageManager->addSuccess(__('The slider has been saved.'));
				$this->_getSession()->setFormData(false);

				return $this->_getBackResultRedirect($resultRedirect, $model->getId());
			} catch (\Exception $e) {
				$this->messageManager->addError($e->getMessage());
				$this->messageManager->addException($e, __('Something went wrong while saving the slider.'));
			}

			$this->_getSession()->setFormData($formPostValues);

			return $resultRedirect->setPath('*/*/edit', [static::PARAM_CRUD_ID => $sliderId]);
		}

		return $resultRedirect->setPath('*/*/');
	}
}
