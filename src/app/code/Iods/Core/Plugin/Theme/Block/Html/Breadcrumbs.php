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
namespace TFC\Core\Plugin\Theme\Block\Html;
use Magento\Theme\Block\Html\Breadcrumbs as Sb;
# 2020-10-28
# 1) "Remove «Home» from breadcrumbs on frontend product pages": https://github.com/tradefurniturecompany/site/issues/199
# 2) "Remove the product name from breadcrumbs on frontend product pages":
# https://github.com/tradefurniturecompany/site/issues/198
final class Breadcrumbs {
	/**
	 * 2020-10-28
	 * @see \Magento\Theme\Block\Html\Breadcrumbs::addCrumb()
	 * @see \Magento\Catalog\Block\Breadcrumbs::_prepareLayout():
	 *	$breadcrumbsBlock->addCrumb('home',[
	 *		'label' => __('Home'),
	 *		'title' => __('Go to Home Page'),
	 *		'link' => $this->_storeManager->getStore()->getBaseUrl()
	 *	]);
	 * @param Sb $sb
	 * @param \Closure $f
	 * @param string $k
	 * @param array(string => mixed) $d
	 * @return Sb
	 */
	function aroundAddCrumb(Sb $sb, \Closure $f, $k, array $d) {
		if (!in_array($k, ['home', 'product']) || !df_is_catalog_product_view()) {
			$f($k, $d);
		}
		return $sb;
	}
}
