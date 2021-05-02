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

namespace Dholi\Widgets\Controller\Adminhtml;

use Dholi\Widgets\Model\ItemFactory;
use Dholi\Widgets\Model\ResourceModel\Slider\Item\CollectionFactory as ItemCollectionFactory;
use Dholi\Widgets\Model\SliderFactory;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Js;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\MassAction\Filter;

abstract class AbstractAction extends \Magento\Backend\App\Action {

	const PARAM_CRUD_ID = 'slider_id';

	protected $jsHelper;

	protected $storeManager;

	protected $resultForwardFactory;

	protected $resultLayoutFactory;

	protected $resultPageFactory;

	protected $itemFactory;

	protected $sliderFactory;

	protected $itemCollectionFactory;

	protected $coreRegistry;

	protected $fileFactory;

	protected $massActionFilter;

	protected $uploaderFactory;

	protected $adapterFactory;

	public function __construct(Context $context,
	                            ItemFactory $itemFactory,
	                            SliderFactory $sliderFactory,
	                            ItemCollectionFactory $itemCollectionFactory,
	                            Registry $coreRegistry,
	                            FileFactory $fileFactory,
	                            PageFactory $resultPageFactory,
	                            LayoutFactory $resultLayoutFactory,
	                            ForwardFactory $resultForwardFactory,
	                            StoreManagerInterface $storeManager,
	                            Js $jsHelper,
	                            Filter $massActionFilter,
	                            UploaderFactory $uploaderFactory,
	                            AdapterFactory $adapterFactory) {

		parent::__construct($context);
		$this->coreRegistry = $coreRegistry;
		$this->fileFactory = $fileFactory;
		$this->storeManager = $storeManager;
		$this->jsHelper = $jsHelper;
		$this->massActionFilter = $massActionFilter;

		$this->resultPageFactory = $resultPageFactory;
		$this->resultLayoutFactory = $resultLayoutFactory;
		$this->resultForwardFactory = $resultForwardFactory;

		$this->itemFactory = $itemFactory;
		$this->sliderFactory = $sliderFactory;
		$this->itemCollectionFactory = $itemCollectionFactory;
		$this->uploaderFactory = $uploaderFactory;
		$this->adapterFactory = $adapterFactory;
	}

	protected function _createMainCollection() {
		$collection = $this->_objectManager->create('Dholi\Widgets\Model\ResourceModel\Slider\Item\Collection');

		return $collection;
	}

	protected function _getBackResultRedirect(\Magento\Framework\Controller\Result\Redirect $resultRedirect, $paramCrudId = null) {
		switch ($this->getRequest()->getParam('back')) {
			case 'edit':
				$resultRedirect->setPath(
					'*/*/edit',
					[
						static::PARAM_CRUD_ID => $paramCrudId,
						'_current' => true,
					]
				);
				break;
			case 'new':
				$resultRedirect->setPath('*/*/new', ['_current' => true]);
				break;
			default:
				$resultRedirect->setPath('*/*/');
		}

		return $resultRedirect;
	}
}
