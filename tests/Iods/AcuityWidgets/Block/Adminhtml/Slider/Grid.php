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

namespace Dholi\Widgets\Block\Adminhtml\Slider;

use Dholi\Widgets\Model\ResourceModel\Slider\CollectionFactory;
use Dholi\Widgets\Model\Status;
use Magento\Backend\Block\Template\Context;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended {

	protected $sliderCollectionFactory;

	public function __construct(Context $context,
	                            \Magento\Backend\Helper\Data $backendHelper,
	                            CollectionFactory $sliderCollectionFactory,
	                            array $data = []) {
		$this->sliderCollectionFactory = $sliderCollectionFactory;
		parent::__construct($context, $backendHelper, $data);
	}

	public function getGridUrl() {
		return $this->getUrl('*/*/grid', array('_current' => true));
	}

	public function getRowUrl($row) {
		return $this->getUrl(
			'*/*/edit',
			array('slider_id' => $row->getId())
		);
	}

	protected function _construct() {
		parent::_construct();
		$this->setId('sliderGrid');
		$this->setDefaultSort('slider_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}

	protected function _prepareCollection() {
		$collection = $this->sliderCollectionFactory->create();
		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns() {
		$this->addColumn(
			'slider_id',
			[
				'header' => __('Slider Id'),
				'type' => 'number',
				'index' => 'slider_id',
				'header_css_class' => 'col-id',
				'column_css_class' => 'col-id',
			]
		);
		$this->addColumn(
			'title',
			[
				'header' => __('Title'),
				'index' => 'title',
				'width' => '50px',
			]
		);

		$this->addColumn(
			'status',
			[
				'header' => __('Status'),
				'index' => 'status',
				'type' => 'options',
				'options' => Status::getAvailableStatuses(),
			]
		);

		$this->addColumn(
			'edit',
			[
				'header' => __('Edit'),
				'type' => 'action',
				'getter' => 'getId',
				'actions' => [
					[
						'caption' => __('Edit'),
						'url' => [
							'base' => '*/*/edit',
						],
						'field' => 'slider_id',
					],
				],
				'filter' => false,
				'sortable' => false,
				'index' => 'stores',
				'header_css_class' => 'col-action',
				'column_css_class' => 'col-action',
			]
		);
		$this->addExportType('*/*/exportCsv', __('CSV'));
		$this->addExportType('*/*/exportXml', __('XML'));
		$this->addExportType('*/*/exportExcel', __('Excel'));

		return parent::_prepareColumns();
	}

	protected function _prepareMassaction() {
		$this->setMassactionIdField('slider_id');
		$this->getMassactionBlock()->setFormFieldName('slider');

		$this->getMassactionBlock()->addItem(
			'delete',
			[
				'label' => __('Delete'),
				'url' => $this->getUrl('dholiwidgets/*/massDelete'),
				'confirm' => __('Are you sure?'),
			]
		);

		$statuses = Status::getAvailableStatuses();

		array_unshift($statuses, ['label' => '', 'value' => '']);
		$this->getMassactionBlock()->addItem(
			'status',
			[
				'label' => __('Change status'),
				'url' => $this->getUrl('dholiwidgets/*/massStatus', ['_current' => true]),
				'additional' => [
					'visibility' => [
						'name' => 'status',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => __('Status'),
						'values' => $statuses,
					],
				],
			]
		);

		return $this;
	}
}
