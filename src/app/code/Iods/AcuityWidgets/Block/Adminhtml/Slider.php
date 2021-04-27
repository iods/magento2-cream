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

namespace Dholi\Widgets\Block\Adminhtml;

class Slider extends \Magento\Backend\Block\Widget\Grid\Container {

	protected function _construct() {
		$this->_controller = 'adminhtml_slider';
		$this->_blockGroup = 'Dholi_Widgets';
		$this->_headerText = __('Sliders');
		$this->_addButtonLabel = __('Add Slider');

		parent::_construct();
	}
}
