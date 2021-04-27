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

namespace CanadaSatellite\Core\Plugin\Magento\Sales\Model\Order;
use Exception as E;
use Magento\Sales\Model\Order\Item as Sb;
# 2021-03-30
# "«Unable to unserialize value. Error: Syntax error» on `sales/order/history`»":
# https://github.com/canadasatellite-ca/site/issues/62
final class Item {
	/**
	 * 2021-03-30
	 * @see \Magento\Sales\Model\Order\Item::getProductOptions()
	 * @param Sb $sb
	 * @param \Closure $f
	 * @return mixed[]
	 */
	function aroundGetProductOptions(Sb $sb, \Closure $f) {return df_try($f, function(E $e) use($sb) {return
		false === ($r = !is_string($o = $sb['product_options']) ? false : @unserialize($o)) ? df_error($e) : $r
	;});}
}
