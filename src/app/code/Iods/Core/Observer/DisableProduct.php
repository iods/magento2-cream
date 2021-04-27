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

use Magento\Framework\Event\Observer;
use Psr\Log\LoggerInterface;

class DisableProduct implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\CatalogInventory\Model\Stock\StockItemRepository
     */
    protected $_stockItemRepository;
    /**
     * @var \Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku
     */
    protected $_getSalableQuantityDataBySku;
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;
    /**
     * @var LoggerInterface
     */
    protected $_logger;
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $_productRepository;

    /**
     * DisableProduct constructor.
     * @param \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository
     * @param \Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku $getSalableQuantityDataBySku
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        \Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku $getSalableQuantityDataBySku,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        LoggerInterface $logger
    ) {
        $this->_stockItemRepository = $stockItemRepository;
        $this->_productRepository = $productRepository;
        $this->_getSalableQuantityDataBySku = $getSalableQuantityDataBySku;
        $this->_productFactory = $productFactory;
        $this->_logger = $logger;
    }

    /**
     *  Disable Product when out stock
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        try {
            $order = $observer->getEvent()->getOrder();
            $items = $order->getAllVisibleItems();
            $ids[] = [];
            for ($i = count($items) - 1; $i>=0; $i--) {
                $this->_logger->debug($items[$i]->getProductId());
                $salable_qty = $this->_getSalableQuantityDataBySku->execute($items[$i]->getSku())[0]["qty"];
                $product = $this->_productRepository->getById($items[$i]->getProductId(), true, 0, false);
                $this->_logger->debug($product->getVisibility());
                if ($product->getTypeId() == "Configurable") {
                    $flag = 0;
                    $childrens = $product->getTypeInstance()->getUsedProducts($product);
                    foreach ($childrens as $child) {
                        if ($child->getStatus() == 1) {
                            $flag++;
                            break;
                        }
                    }
                    if ($flag == 0) {
                        $product->setData('status', 2);
                        $product->getResource()->saveAttribute($product, 'status');
                    }
                } else {
                    $this->_logger->debug($salable_qty);
                    if ($salable_qty == 0) {
                        $product->setData('status', 2);
                        $product->getResource()->saveAttribute($product, 'status');
                    }else {
                        $product->setData('status', 1);
                        $product->getResource()->saveAttribute($product, 'status');
                    }
                }
            }
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
    }
}
