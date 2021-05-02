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

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Dholi\Widgets\Controller\Adminhtml\Slideritem {

	public function execute() {
		$resultRedirect = $this->resultRedirectFactory->create();

		if ($data = $this->getRequest()->getPostValue()) {
			$model = $this->itemFactory->create();
			$storeId = $this->getRequest()->getParam('store');

			if ($id = $this->getRequest()->getParam(static::PARAM_CRUD_ID)) {
				$model->load($id);
			}

			$imageRequest = $this->getRequest()->getFiles('image');
			if ($imageRequest) {
				if (isset($imageRequest['name'])) {
					$fileName = $imageRequest['name'];
				} else {
					$fileName = '';
				}
			} else {
				$fileName = '';
			}

			if ($imageRequest && strlen($fileName)) {
				try {
					$uploader = $this->uploaderFactory->create(['fileId' => 'image']);

					$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

					$imageAdapter = $this->adapterFactory->create();

					$uploader->addValidateCallback('item_image', $imageAdapter, 'validateUploadFile');
					$uploader->setAllowRenameFiles(true);
					$uploader->setFilesDispersion(true);

					$mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::MEDIA);
					$result = $uploader->save($mediaDirectory->getAbsolutePath(\Dholi\Widgets\Model\Item::BASE_MEDIA_PATH));
					$data['image'] = \Dholi\Widgets\Model\Item::BASE_MEDIA_PATH . $result['file'];
				} catch (\Exception $e) {
					if ($e->getCode() == 0) {
						$this->messageManager->addError($e->getMessage());
					}
				}
			} else {
				if (isset($data['image']) && isset($data['image']['value'])) {
					if (isset($data['image']['delete'])) {
						$data['image'] = null;
						$data['delete_image'] = true;
					} elseif (isset($data['image']['value'])) {
						$data['image'] = $data['image']['value'];
					} else {
						$data['image'] = null;
					}
				}
			}
			$model->setData($data)->setStoreId($storeId);

			try {
				$model->save();

				$this->messageManager->addSuccess(__('The slider item has been saved.'));
				$this->_getSession()->setFormData(false);

				return $this->_getBackResultRedirect($resultRedirect, $model->getId());
			} catch (\Exception $e) {
				$this->messageManager->addError($e->getMessage());
				$this->messageManager->addException($e, __('Something went wrong while saving the item.'));
			}
			$this->_getSession()->setFormData($data);

			return $resultRedirect->setPath('*/*/edit', [static::PARAM_CRUD_ID => $this->getRequest()->getParam(static::PARAM_CRUD_ID)]);
		}

		return $resultRedirect->setPath('*/*/');
	}
}