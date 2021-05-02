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

namespace Dholi\Widgets\Block\Adminhtml\Slider\Edit\Tab;

use Dholi\Widgets\Model\Status;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class Form extends Generic implements TabInterface {

	const FIELD_NAME_SUFFIX = 'slider';

	protected $fieldFactory;

	public function __construct(Context $context, Registry $registry, FormFactory $formFactory, FieldFactory $fieldFactory, array $data = []) {
		$this->fieldFactory = $fieldFactory;

		parent::__construct($context, $registry, $formFactory, $data);
	}

	public function getTabLabel() {
		return __('Slider Information');
	}

	public function getTabTitle() {
		return __('Slider Information');
	}

	public function canShowTab() {
		return true;
	}

	public function isHidden() {
		return false;
	}

	protected function _prepareLayout() {
		$this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());
	}

	public function getPageTitle() {
		return $this->getSlider()->getId() ? __("Edit Slider '%1'", $this->escapeHtml($this->getSlider()->getTitle())) : __('Add Slider');
	}

	public function getSlider() {
		return $this->_coreRegistry->registry('slider');
	}

	protected function _prepareForm() {
		$slider = $this->getSlider();
		$isElementDisabled = true;
		$form = $this->_formFactory->create();

		$dependenceBlock = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Form\Element\Dependence');
		$fieldMaps = [];

		$form->setHtmlIdPrefix('page_');

		$fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Slider Information')]);

		if ($slider->getId()) {
			$fieldset->addField('slider_id', 'hidden', ['name' => 'slider_id']);
		}

		$fieldset->addField(
			'title',
			'text',
			[
				'name' => 'title',
				'label' => __('Title'),
				'title' => __('Title'),
				'required' => true,
				'class' => 'required-entry',
			]
		);

		$fieldMaps['description'] = $fieldset->addField(
			'description',
			'editor',
			[
				'name' => 'description',
				'label' => __('Description'),
				'title' => __('Description'),
				'wysiwyg' => true,
				'required' => false,
			]
		);

		$fieldMaps['status'] = $fieldset->addField(
			'status',
			'select',
			[
				'label' => __('Status'),
				'title' => __('Status'),
				'name' => 'status',
				'options' => Status::getAvailableStatuses(),
				'disabled' => false,
			]
		);

		$positionImage = [];
		for ($i = 1; $i <= 5; ++$i) {
			$positionImage[] = $this->getViewFileUrl("Dholi_Widgets::images/position/itenslider-ex{$i}.png");
		}

		/*
		 * Add field map
		 */
		foreach ($fieldMaps as $fieldMap) {
			$dependenceBlock->addFieldMap($fieldMap->getHtmlId(), $fieldMap->getName());
		}
		$mappingFieldDependence = $this->getMappingFieldDependence();

		/*
		 * Add field dependence
		 */
		foreach ($mappingFieldDependence as $dependence) {
			$negative = isset($dependence['negative']) && $dependence['negative'];
			if (is_array($dependence['fieldName'])) {
				foreach ($dependence['fieldName'] as $fieldName) {
					//$dependenceBlock->addFieldDependence($fieldMaps[$fieldName]->getName(), $this->getDependencyField($dependence['refField'], $negative));
				}
			} else {
				//$dependenceBlock->addFieldDependence($fieldMaps[$dependence['fieldName']]->getName(), $this->getDependencyField($dependence['refField'], $negative));
			}
		}
		/*
		 * add child block dependence
		 */
		$this->setChild('form_after', $dependenceBlock);

		if (!$slider->getId()) {
			$slider->setStatus($isElementDisabled ? Status::ENABLED : Status::DISABLED);
		}
		$form->setValues($slider->getData());
		$form->addFieldNameSuffix(self::FIELD_NAME_SUFFIX);
		$this->setForm($form);

		return parent::_prepareForm();
	}

	public function getMappingFieldDependence() {
		return [
			[
				'fieldName' => 'title',
				'fieldNameFrom' => false,
				'refField' => '',
				'negative' => true,
			],
		];
	}

	public function getDependencyField($refField, $negative = false, $separator = ',', $fieldPrefix = '') {
		return $this->fieldFactory->create(
			['fieldData' => ['value' => (string)$refField, 'negative' => $negative, 'separator' => $separator], 'fieldPrefix' => $fieldPrefix]
		);
	}
}