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

namespace Dholi\Widgets\Block\Adminhtml\Slider\Item;

class Edit extends \Magento\Backend\Block\Widget\Form\Container {

	protected function _construct() {
		$this->_objectId = 'item_id';
		$this->_blockGroup = 'Dholi_Widgets';
		$this->_controller = 'adminhtml_slider_item';

		parent::_construct();

		$this->buttonList->update('save', 'label', __('Save'));
		$this->buttonList->update('delete', 'label', __('Delete'));

		if ($this->getRequest()->getParam('current_slider_id')) {
			$this->buttonList->remove('save');
			$this->buttonList->remove('delete');

			$this->buttonList->remove('back');
			$this->buttonList->add(
				'close_window',
				[
					'label' => __('Close Window'),
					'onclick' => 'window.close();',
				],
				10
			);

			$this->buttonList->add(
				'save_and_continue',
				[
					'label' => __('Save and Continue Edit'),
					'class' => 'save',
					'onclick' => 'customsaveAndContinueEdit()',
				],
				10
			);

			$this->buttonList->add(
				'save_and_close',
				[
					'label' => __('Save and Close'),
					'class' => 'save_and_close',
					'onclick' => 'saveAndCloseWindow()',
				],
				10
			);

			$this->_formScripts[] = "
				require(['jquery'], function($){
					$(document).ready(function(){
						let input = $('<input class=\"custom-button-submit\" type=\"submit\" hidden=\"true\" />');
						$(edit_form).append(input);

						window.customsaveAndContinueEdit = function (){
							edit_form.action = '" . $this->getSaveAndContinueUrl() . "';
							$('.custom-button-submit').trigger('click');
						}

		        window.saveAndCloseWindow = function (){
		          edit_form.action = '" . $this->getSaveAndCloseWindowUrl() . "';
						  $('.custom-button-submit').trigger('click');
		        }
					});
				});
			";

			if ($itemId = $this->getRequest()->getParam('item_id')) {
				$this->_formScripts[] = 'window.item_id = ' . $itemId . ';';
			}
		} else {
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
		}

		if ($this->getRequest()->getParam('saveandclose')) {
			$this->_formScripts[] = 'window.close();';
		}
	}

	protected function getSaveAndContinueUrl() {
		return $this->getUrl(
			'*/*/save',
			[
				'_current' => true,
				'back' => 'edit',
				'tab' => '{{tab_id}}',
				'store' => $this->getRequest()->getParam('store'),
				'item_id' => $this->getRequest()->getParam('item_id'),
				'current_slider_id' => $this->getRequest()->getParam('current_slider_id'),
			]
		);
	}

	protected function getSaveAndCloseWindowUrl() {
		return $this->getUrl(
			'*/*/save',
			[
				'_current' => true,
				'back' => 'edit',
				'tab' => '{{tab_id}}',
				'store' => $this->getRequest()->getParam('store'),
				'item_id' => $this->getRequest()->getParam('item_id'),
				'current_slider_id' => $this->getRequest()->getParam('current_slider_id'),
				'saveandclose' => 1,
			]
		);
	}
}
