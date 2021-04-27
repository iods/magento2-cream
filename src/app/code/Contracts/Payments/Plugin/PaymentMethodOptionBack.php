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

namespace Dholi\Payment\Plugin;

use Magento\SalesRule\Model\Rule\Condition\Address;

class PaymentMethodOptionBack {

	/**
	 * @param Address $subject
	 * @param $result
	 * @return Address
	 */
	public function afterLoadAttributeOptions(Address $subject, $result) {
		$attributeOption = $subject->getAttributeOption();
		$attributeOption['payment_method'] = __('Payment Method');

		$subject->setAttributeOption($attributeOption);

		return $subject;
	}
}