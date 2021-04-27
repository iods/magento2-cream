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

namespace Dholi\Payment\Block\Adminhtml\Sales\Order;

class Totals extends \Magento\Framework\View\Element\Template {

	private $order;
	private $source;

	public function __construct(\Magento\Framework\View\Element\Template\Context $context, array $data = []) {
		parent:: __construct($context, $data);
	}

	public function getSource() {
		return $this->source;
	}

	public function initTotals() {
		$parent = $this->getParentBlock();
		$this->order = $parent->getOrder();
		$this->source = $parent->getSource();

		/**
		 * Descontos
		 */
		$amount = $this->source->getPayuDiscountAmount();
		if ($amount < 0) {
			$custom = new \Magento\Framework\DataObject([
					'code' => 'dholi_discount',
					'strong' => false,
					'value' => $amount,
					'base_value' => $this->source->getPayuBaseDiscountAmount(),
					'label' => __('Discount first installment'),
				]
			);

			$parent->addTotalBefore($custom, 'grand_total');
		}

		/**
		 * Juros
		 */
		$amount = $this->source->getPayuInterestAmount();
		if ($amount > 0) {
			$custom = new \Magento\Framework\DataObject([
					'code' => 'dholi_interest',
					'strong' => false,
					'value' => $amount,
					'base_value' => $this->source->getPayuBaseInterestAmount(),
					'label' => __('Interest'),
				]
			);

			$parent->addTotalBefore($custom, 'grand_total');
		}

		return $this;
	}

}