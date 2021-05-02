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
namespace TFC\Core\Plugin\Tax\Model;
use Magento\Store\Model\Store;
use Magento\Tax\Model\Config as Sb;
/**
 * 2019-10-07
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * "Transfer the `\Magento\Tax\Helper\Data::getShippingPrice()`
 * and `\Magento\Tax\Model\Config::needPriceConversion()` methods modifications
 * to the `tradefurniturecompany/core` module": https://github.com/tradefurniturecompany/core/issues/14
 */
class Config extends Sb {
	/** 2019-10-07 */
	function __construct() {}

	/**
	 * 2019-10-07
	 * @see \Magento\Tax\Model\Config::needPriceConversion()
	 * @param Sb $sb
	 * @param \Closure $f
	 * @param null|int|string|Store $s [optional]
	 * @return bool|int
	 */
	function aroundNeedPriceConversion(Sb $sb, \Closure $f, $s = null) {
		$res = 0;
		// 2019-09-20 Dmitry Fedyuk https://www.upwork.com/fl/mage2pro
		// "The «Delivery and Installation» fee should be shown with taxes":
		// https://github.com/tradefurniturecompany/core/issues/3
		$priceIncludesTax =
			(self::$_shippingMode ? $sb->shippingPriceIncludesTax($s) : $sb->priceIncludesTax($s))
			|| $sb->getNeedUseShippingExcludeTax()
		;
		/** @var bool $displayType */
		$displayType = self::$_shippingMode ? $sb->getShippingPriceDisplayType($s) : $sb->getPriceDisplayType($s);
		if ($priceIncludesTax) {
			switch ($displayType) {
				case $sb::DISPLAY_TYPE_EXCLUDING_TAX:
				case $sb::DISPLAY_TYPE_BOTH:
					return $sb::PRICE_CONVERSION_MINUS;
				case $sb::DISPLAY_TYPE_INCLUDING_TAX:
					$res = false;
			}
		}
		else switch ($displayType) {
			case $sb::DISPLAY_TYPE_INCLUDING_TAX:
			case $sb::DISPLAY_TYPE_BOTH:
				return $sb::PRICE_CONVERSION_PLUS;
			case $sb::DISPLAY_TYPE_EXCLUDING_TAX:
				$res = false;
		}
		if ($res === false) {
			$res = $sb->displayCartPricesBoth();
		}
		return $res;
	}

	/**
	 * 2019-09-20 Dmitry Fedyuk https://www.upwork.com/fl/mage2pro
	 * "The «Delivery and Installation» fee should be shown with taxes":
	 * https://github.com/tradefurniturecompany/core/issues/3
	 * @used-by \TFC\Core\Plugin\Tax\Helper\Data::aroundGetShippingPrice()
	 * @param bool $v
	 */
    static function shippingModeSet($v) {self::$_shippingMode = $v;}

	/**
	 * 2019-09-20 Dmitry Fedyuk https://www.upwork.com/fl/mage2pro
	 * "The «Delivery and Installation» fee should be shown with taxes":
	 * https://github.com/tradefurniturecompany/core/issues/3
	 * @used-by aroundNeedPriceConversion()
	 * @used-by shippingModeSet()
	 * @var bool
	 */
    private static $_shippingMode;
}
