<?php

namespace Dholi\Widgets\Controller\Adminhtml\Slideritem;

class Edit extends \Dholi\Widgets\Controller\Adminhtml\Slideritem {
	public function execute() {
		$id = $this->getRequest()->getParam('item_id');
		$storeId = $this->getRequest()->getParam('store');
		$model = $this->itemFactory->create();

		if ($id) {
			$model->setStoreId($storeId)->load($id);
			if (!$model->getId()) {
				$this->messageManager->addError(__('This item no longer exists.'));
				$resultRedirect = $this->resultRedirectFactory->create();

				return $resultRedirect->setPath('*/*/');
			}
		}

		$data = $this->_getSession()->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		$this->coreRegistry->register('item', $model);

		$resultPage = $this->resultPageFactory->create();

		return $resultPage;
	}
}
