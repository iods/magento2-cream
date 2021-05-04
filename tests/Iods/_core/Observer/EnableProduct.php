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

namespace Iods\Core\Observer;

use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class EnableProduct implements ObserverInterface
{
    protected $_product;

    protected $_logger;

    protected $productRepository;

    protected $getSaleableQuantity;

    protected $stockRegistry;

    protected $_stockItemRepository;

    public function __construct(
        StockRegistryInterface $stockRegistry,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        LoggerInterface $logger
    ) {
        $this->stockRegistry = $stockRegistry;
        $this->_stockItemRepository = $stockItemRepository;
        $this->_logger = $logger;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $product = $observer->getProduct();
        $productId = $product->getId();
        $productQty = $this->getStockItem($product->getId())->getQty();
        $productType = $product->getTypeId();
        /** @var StockItemInterface $stockItem */
        $stockItem = $this->stockRegistry->getStockItem($productId);
        $isInStock = $stockItem ? $stockItem->getIsInStock() : false;
        if ($isInStock == true && $productQty > 0) {
            $product->setData('status', 1);
            $product->getResource()->saveAttribute($product, 'status');
        }else {
            $product->setData('status', 2);
            $product->getResource()->saveAttribute($product, 'status');
        }
        if ($productType == 'configurable') {
            $dem = 0;
            $allProducts = $product->getTypeInstance()->getUsedProducts($product);
            foreach ($allProducts as $item) {
                $child = $this->stockRegistry->getStockItem($item->getId());
                $childQty = $child->getQty();
                $childinStock = $child ? $child : false;
                if ($childinStock == true && $childQty > 0) {
                    $item->setData('status', 1);
                    $item->getResource()->saveAttribute($item, 'status');
                    $dem++;
                }else {
                    $item->setData('status', 2);
                    $item->getResource()->saveAttribute($item, 'status');
                }

                if ($dem > 0) {
                    $product->setData('status', 1);
                    $product->getResource()->saveAttribute($product, 'status');
                }else {
                    $product->setData('status', 2);
                    $product->getResource()->saveAttribute($product, 'status');
                }
            }
        }
    }
    public function getStockItem($productId)
    {
        return $this->_stockItemRepository->get($productId);
    }
}
