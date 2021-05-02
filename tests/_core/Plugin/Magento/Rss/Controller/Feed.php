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
namespace CanadaSatellite\Core\Plugin\Magento\Rss\Controller;
use Magento\Framework\Exception\NotFoundException as NFE;
use Magento\Rss\Controller\Feed as Sb;
# 2021-03-25
# "Disable RSS for `Mageplaza_Blog` if the `rss/config/active` option is disabled":
# https://github.com/canadasatellite-ca/site/issues/43
final class Feed {
	/**
	 * 2021-03-25
	 * @see \Magento\Framework\App\ActionInterface::execute()
	 * @see \Mageplaza\Blog\Controller\Category\Rss::execute()
	 * @see \Mageplaza\Blog\Controller\Post\Rss::execute()
	 * @used-by \Magento\Framework\App\Action\Action::dispatch()
	 * @param Sb $sb
	 * @throws NFE
	 */
	function beforeExecute(Sb $sb) {
		if (!df_cfg('rss/config/active') && df_starts_with(get_class($sb), 'Mageplaza')) {
			/**
			 * 2021-03-25
			 * By analogy with @see \Magento\Rss\Controller\Feed\Index::execute()
			 * https://github.com/magento/magento2/blob/2.3.5-p2/app/code/Magento/Rss/Controller/Feed/Index.php#L25-L27
			 * https://github.com/canadasatellite-ca/site/issues/43#issuecomment-806507581
			 */
			df_throw_404();
		}
	}
}
