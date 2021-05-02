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
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Factory;

class Wysiwyg extends Template {

	protected $wysiwygConfig;

	protected $factoryElement;

	public function __construct(Context $context, Factory $factoryElement, Config $wysiwygConfig, $data = []) {
		$this->factoryElement = $factoryElement;
		$this->wysiwygConfig = $wysiwygConfig;
		parent::__construct($context, $data);
	}

	public function prepareElementHtml(AbstractElement $element) {
		$editor = $this->factoryElement->create('editor', ['data' => $element->getData()])
			->setLabel('')
			->setForm($element->getForm())
			->setWysiwyg(true)
			->setConfig(
				$this->wysiwygConfig->getConfig([
					'add_variables' => false,
					'add_widgets' => false,
					'add_images' => false
				])
			);
		if ($element->getRequired()) {
			$editor->addClass('required-entry');
		}
		$element->setData('after_element_html', $editor->getElementHtml());
		$element->setValue('');

		return $element;
	}

}