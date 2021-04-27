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
namespace TFC\Core\Plugin\Sales\Model;
use Magento\Sales\Model\Order as Sb;
use Magento\Sales\Model\Order\Item as I;
use Magento\Sales\Model\ResourceModel\Order\Item\Collection as C;
/**
 * 2020-02-19
 * 1) "«The product that was requested doesn't exist. Verify the product and try again.»
 * at vendor/magento/module-catalog/Model/ProductRepository.php:310":
 * https://github.com/tradefurniturecompany/site/issues/20
 * 2) The `sales_order_item` table sometimes has a wrong `0` value in the `product_id` column
 * for orders placed before the website was migrated to Magento 2:
 * https://github.com/tradefurniturecompany/site/issues/20#issuecomment-587985765
 */
final class Order {
	/**
	 * 2020-02-19
	 * 1) @see \Magento\Sales\Model\Order::getParentItemsRandomCollection()
	 * https://github.com/magento/magento2/blob/2.3.4/app/code/Magento/Sales/Model/Order.php#L1417-L1426
	 * 2) @see \Magento\Sales\CustomerData\LastOrderedItems::getItems():
	 *		foreach ($order->getParentItemsRandomCollection($limit) as $item) {
	 *			try {
	 *				$product = $this->productRepository->getById(
	 *				$item->getProductId(),
	 *				false,
	 *				$this->_storeManager->getStore()->getId()
	 *				);
	 *			}
	 * 			catch (NoSuchEntityException $noEntityException) {
	 *				$this->logger->critical($noEntityException);
	 *				continue;
	 *			}
	 *			if (isset($product) && in_array($website, $product->getWebsiteIds())) {
	 *				$url = $product->isVisibleInSiteVisibility() ? $product->getProductUrl() : null;
	 *				$items[] = [
	 *					'id' => $item->getId(),
	 *					'name' => $item->getName(),
	 *					'url' => $url,
	 *					'is_saleable' => $this->isItemAvailableForReorder($item),
	 *				];
	 *			}
	 *		}
	 * https://github.com/magento/magento2/blob/2.3.4/app/code/Magento/Sales/CustomerData/LastOrderedItems.php#L129-L150
	 * @param Sb $sb
	 * @param C $r
	 * @return I[]
	 */
	function afterGetParentItemsRandomCollection(Sb $sb, C $r) {return df_filter($r, function(I $i) {return
		$i->getProductId()
	;});}
}
