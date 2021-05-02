<?php
/**
* 
* Payment Core para Magento 2
* 
* @category     Dholi
* @package      Modulo Payment Core
* @copyright    Copyright (c) 2021 dholi (https://www.dholi.dev)
* @version      1.1.1
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/
declare(strict_types=1);

namespace Dholi\Payment\Block\Adminhtml\Config\Source;

class CreditCardIcons implements \Magento\Framework\Option\ArrayInterface {

	/**
	 * {@inheritdoc}
	 */
	public function toOptionArray() {
		return [
			['value' => 'none', 'label' => __('No icon')],
			['value' => 'flat', 'label' => __('Flat icon')],
			['value' => 'mono', 'label' => __('Mono icon')],
			['value' => 'outline', 'label' => __('Outline icon')],
			['value' => 'single', 'label' => __('Single icon')]
		];
	}

}