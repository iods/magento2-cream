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

use Magento\Framework\Controller\ResultFactory;

class MassDelete extends \Dholi\Widgets\Controller\Adminhtml\AbstractAction {

	public function execute() {
		$sliderIds = $this->getRequest()->getParam('slider');
		if (!is_array($sliderIds) || empty($sliderIds)) {
			$this->messageManager->addErrorMessage(__('Please select slider(s).'));
		} else {
			try {
				foreach ($sliderIds as $sliderUd) {
					$slider = $this->_objectManager->create('Dholi\Widgets\Model\Slider')
						->load($sliderUd);
					$slider->delete();
				}
				$this->messageManager->addSuccessMessage(
					__('A total of %1 record(s) have been deleted.', count($sliderIds))
				);
			} catch (\Exception $e) {
				$this->messageManager->addErrorMessage($e->getMessage());
			}
		}
		$resultRedirect = $this->resultRedirectFactory->create();
		return $resultRedirect->setPath('*/*/');
	}
}
