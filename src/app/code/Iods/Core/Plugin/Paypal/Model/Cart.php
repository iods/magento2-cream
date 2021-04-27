<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Core\Plugin\Block;
namespace TFC\Core\Plugin\Paypal\Model;
use Closure as F;
use Magento\Paypal\Model\Cart as Sb;
# 2020-12-24
# «PayPal gateway has rejected request. The totals of the cart item amounts do not match order amounts»:
# https://github.com/tradefurniturecompany/site/issues/211
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Cart extends Sb {
	/**
	 * 2016-01-01
	 * The empty constructor allows us to skip the parent's one.
	 * Magento (at least at 2016-01-01) is unable to properly inject arguments into a plugin's constructor,
	 * and it leads to the error like: «Missing required argument $amount of Magento\Framework\Pricing\Amount\Base».
	 */
	function __construct() {}

	/**
	 * 2020-12-24
	 * @see \Magento\Paypal\Model\Cart::getAmounts()
	 * @used-by \Magento\Paypal\Model\Api\AbstractApi::_exportLineItems()
	 * @param Sb $sb
	 * @param F $f
	 * @return array(string => float) $r
	 */
	function aroundGetAmounts(Sb $sb, F $f) {
		# 2020-12-24 https://github.com/magento/magento2/blob/2.3.2/app/code/Magento/Paypal/Model/Cart.php#L28
		$sb->_collectItemsAndAmounts();
		/** @var array(string => float) $r */
		# 2020-12-24 https://github.com/magento/magento2/blob/2.3.2/app/code/Magento/Paypal/Model/Cart.php#L30-L42
		if (!$sb->_areAmountsValid) {
			$subtotal = $sb->getSubtotal() + $sb->getTax();
			if (empty($sb->_transferFlags[$sb::AMOUNT_SHIPPING])) {
				$subtotal += $sb->getShipping();
			}
			if (empty($sb->_transferFlags[$sb::AMOUNT_DISCOUNT])) {
				$subtotal -= $sb->getDiscount();
			}
			$r = [$sb::AMOUNT_SUBTOTAL => $subtotal];
		}
		else {
			/** 2020-12-24 @see \Magento\Paypal\Model\Cart::_validate() */
			$total = $sb->_salesModel->getDataUsingMethod('grand_total'); /** @var float $total */
			$sum = array_sum($sb->_amounts); /** @var float $sum */
			if (!dff_eq0($diff = $total - $sum, .01)) {
				$sb->_amounts[$sb::AMOUNT_SUBTOTAL] += dff_2f($diff);
			}
			$r = $sb->_amounts;
		}
		return $r;
	}
}
