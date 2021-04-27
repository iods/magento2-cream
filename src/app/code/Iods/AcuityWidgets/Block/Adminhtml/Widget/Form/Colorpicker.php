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
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory;

class Colorpicker extends Template {

	protected $elementFactory;

	public function __construct(Context $context, Factory $elementFactory, array $data = []) {
		$this->elementFactory = $elementFactory;
		parent::__construct($context, $data);
	}

	public function prepareElementHtml(AbstractElement $element) {
		//$html = '<script>jQuery(function() {jQuery("#' . $element->getHtmlId() . '").addClass("color-input").attr("style", "width: 280px !important");var elem = document.getElementById("' . $element->getHtmlId() . '");new Huebee(elem, {notation: "hex",shades: 7});});</script>';
		$input = $this->elementFactory->create("text", ['data' => $element->getData()]);
		$input->setId($element->getId());
		$input->setForm($element->getForm());
		$input->setClass("widget-option input-text admin__control-text color-input");
		if ($element->getRequired()) {
			$input->addClass('required-entry');
		}
		$element->setData('after_element_html', $input->getElementHtml());

		return $element;
	}
}