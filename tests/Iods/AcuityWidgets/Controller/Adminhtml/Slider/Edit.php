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

class Edit extends \Dholi\Widgets\Controller\Adminhtml\Slider {

	public function execute() {
		$resultPage = $this->resultPageFactory->create();

		$id = $this->getRequest()->getParam('slider_id');
		$model = $this->sliderFactory->create();

		if ($id) {
			$model->load($id);
			if (!$model->getId()) {
				$this->messageManager->addError(__('This slider no longer exists.'));

				$resultRedirect = $this->resultRedirectFactory->create();

				return $resultRedirect->setPath('*/*/');
			}
		}

		$data = $this->_getSession()->getFormData(true);

		if (!empty($data)) {
			$model->setData($data);
		}
		$this->coreRegistry->register('slider', $model);

		return $resultPage;
	}
}
