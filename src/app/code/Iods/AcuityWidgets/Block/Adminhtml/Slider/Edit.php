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

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\Block\Widget\Form\Container {

	protected $coreRegistry;

	public function __construct(Context $context, Registry $registry, array $data = []) {
		$this->coreRegistry = $registry;
		parent::__construct($context, $data);
	}

	protected function _construct() {
		$this->_objectId = 'slider_id';
		$this->_blockGroup = 'Dholi_Widgets';
		$this->_controller = 'adminhtml_slider';

		parent::_construct();

		$this->buttonList->update('save', 'label', __('Save'));
		$this->buttonList->update('delete', 'label', __('Delete'));

		if ($this->getSlider()->getId()) {
			$this->buttonList->add(
				'create_item',
				[
					'label' => __('Add'),
					'class' => 'add',
					'onclick' => 'openItemPopupWindow(\'' . $this->getCreateItemUrl() . '\')',
				],
				1
			);
		}

		$this->buttonList->add(
			'save_and_continue',
			[
				'label' => __('Save and Continue Edit'),
				'class' => 'save',
				'data_attribute' => [
					'mage-init' => [
						'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
					],
				],
			],
			10
		);

		$this->_formScripts[] = "
			require(['jquery'], function($){
				window.openItemPopupWindow = function (url) {
					var left = ($(document).width()-1000)/2, height= $(document).height();
					var create_item_popupwindow = window.open(url, '_blank','width=1000,resizable=1,scrollbars=1,toolbar=1,'+'left='+left+',height='+height);
					var windowFocusHandle = function(){
						if (create_item_popupwindow.closed) {
							if (typeof itemGridJsObject !== 'undefined' && create_item_popupwindow.item_id) {
								itemGridJsObject.reloadParams['item[]'].push(create_item_popupwindow.item_id + '');
								$(edit_form.slider_item).val($(edit_form.slider_item).val() + '&' + create_item_popupwindow.item_id + '=' + Base64.encode('order_item_slider=0'));
				       			itemGridJsObject.setPage(create_item_popupwindow.item_id);
				       		}
				       		$(window).off('focus',windowFocusHandle);
						} else {
							$(create_item_popupwindow).trigger('focus');
							create_item_popupwindow.alert('" . __('You have to save item and close this window!') . "');
						}
					}
					$(window).focus(windowFocusHandle);
				}
			});
		";
	}

	public function getSlider() {
		return $this->coreRegistry->registry('slider');
	}

	public function getCreateItemUrl() {
		return $this->getUrl('*/slideritem/new', ['current_slider_id' => $this->getSlider()->getId()]);
	}

	protected function _getSaveAndContinueUrl() {
		return $this->getUrl(
			'*/*/save',
			['_current' => true, 'back' => 'edit', 'tab' => '{{tab_id}}']
		);
	}
}
