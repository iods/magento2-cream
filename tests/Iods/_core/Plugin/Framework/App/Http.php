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

namespace CanadaSatellite\Core\Plugin\Magento\Framework\App;
use Magento\Framework\App\Http as Sb;
use Magento\Framework\App\ResponseInterface as IResponse;
# 2021-04-18 "Ban malicious bots": https://github.com/canadasatellite-ca/site/issues/72
final class Http {
	/**
	 * 2021-04-19
	 * @param Sb $sb
	 * @param \Closure $f
	 * @return IResponse
	 */
	function aroundLaunch(Sb $sb, \Closure $f) {return
		!df_referer()
		&& df_request_o()->isPost()
		&& 3 === count($a = df_request())
		&& !array_diff(array_keys($a), ['form_key', 'product', 'uenc'])
		? df_403() : $f()
	;}
}
