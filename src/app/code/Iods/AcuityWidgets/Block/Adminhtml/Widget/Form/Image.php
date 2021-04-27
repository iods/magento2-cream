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

namespace Dholi\Widgets\Block\Adminhtml\Widget\Form;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context as TemplateContext;
use Magento\Backend\Block\Widget\Button;
use Magento\Framework\Data\Form\Element\AbstractElement as Element;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\Factory as FormElementFactory;
use Magento\Framework\Data\Form\Element\Text;

class Image extends Template {

	protected $elementFactory;

	public function __construct(TemplateContext $context, FormElementFactory $elementFactory, $data = []) {
		$this->elementFactory = $elementFactory;
		parent::__construct($context, $data);
	}

	public function prepareElementHtml(Element $element) {
		$config = $this->_getData('config');
		$sourceUrl = $this->getUrl('cms/wysiwyg_images/index', ['target_element_id' => $element->getId(), 'type' => 'file']);
		$chooser = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Button')
			->setType('button')
			->setClass('btn-chooser')
			->setLabel($config['button']['open'])
			->setOnClick('MediabrowserUtility.openDialog(\'' . $sourceUrl . '\', 0, 0, "MediaBrowser", {})')
			->setDisabled($element->getReadonly());

		$input = $this->elementFactory->create("text", ['data' => $element->getData()]);
		$input->setId($element->getId())->setForm($element->getForm())->setClass("widget-option input-text admin__control-text");
		if ($element->getRequired()) {
			$input->addClass('required-entry');
		}
		$element->setData('after_element_html', $input->getElementHtml() . $chooser->toHtml() . "<script>require(['mage/adminhtml/browser']);</script>");

		return $element;
	}
}