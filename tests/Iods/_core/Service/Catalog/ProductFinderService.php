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

namespace Iods\Core\Service\Catalog;

use Magento\Catalog\Model\Config as CatalogConfig;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\CatalogInventory\Helper\Stock as StockHelper;
use Magento\Framework\App\ResourceConnection;

class ProductFinderService
{
    private $productCollectionFactory;

    private $areaContextService;

    private $ruleRepository;

    private $resource;

    private $catalogConfig;

    private $stockHelper;

    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        RuleRepository $ruleRepository,
        AreaContextService $areaContextService,
        ResourceConnection $resource,
        CatalogConfig $catalogConfig,
        StockHelper $stockHelper
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->ruleRepository           = $ruleRepository;
        $this->areaContextService       = $areaContextService;
        $this->resource                 = $resource;
        $this->catalogConfig            = $catalogConfig;
        $this->stockHelper              = $stockHelper;
    }

    public function getProducts(BlockInterface $block)
    {
        $rule       = $this->ruleRepository->get($block->getRuleId());
        $productIds = $this->getRuleProducts($rule);

        if (count($productIds) == 0) {
            $productIds = [0];
        }
        $collection = $this->getBaseCollection();
        $collection->setPageSize($block->getDisplayProductsLimit());
        $collection->addFieldToFilter('entity_id', ['in' => $productIds]);
        $collection->getSelect()->order('FIELD(e.entity_id, ' . implode(',', $productIds) . ')');

        //if ($_SERVER['REMOTE_ADDR'] == '212.90.62.235') {


        // get object of the current frontend page product
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product = $objectManager->create('Mirasvit\Related\Service\AreaContext\RequestContext')->getProduct();


        if ($block->getId() == 2) {
            if ($product->getData("attribute_set_id") != 9) {
                return [];
            }
        }

        return $collection;
    }

    private function getRuleProducts(RuleInterface $rule)
    {
        $collection = $this->getBaseCollection();

        $productIds = $this->areaContextService->getAttributeValue('entity_id');

        if ($rule->getSource() != RuleInterface::SOURCE_ALL) {
            if (!$productIds || count($productIds) == 0) {
                return [];
            }

            $collection->getSelect()->joinLeft(
                ['index' => $this->resource->getTableName(IndexInterface::TABLE_NAME)],
                'index.linked_product_id = e.entity_id',
                ''
            )
                ->where('index.source=?', $rule->getSource())
                ->where('index.product_id IN(?)', $productIds)
                ->order('SUM(index.score) desc');
        } else {
            # when score isn't applicable, order by rand
            $collection->getSelect()
                ->order('rand()');
        }

        $collection->getSelect()
            ->group('e.entity_id')
            ->limit(10);

        if ($productIds && count($productIds) > 0) {
            $collection->getSelect()
                ->where('e.entity_id NOT IN(?)', $productIds);
        }

        $ids = $rule->getRule()->getMatchedProductIds($collection);

        if ($productIds) {
            $nativeIds = $this->getNativeLinkedProductIds($productIds, $rule);

            $ids = array_merge($nativeIds, $ids);
        }

        return $ids;
    }

    private function getBaseCollection()
    {
        $collection = $this->productCollectionFactory->create();

        $collection
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addUrlRewrite();

        $collection->addAttributeToSelect($this->catalogConfig->getProductAttributes());

        $collection->setVisibility([2, 4]);

        $this->stockHelper->addInStockFilterToCollection($collection);



        $objectManager   = \Magento\Framework\App\ObjectManager::getInstance();
        $product         = $objectManager->create('Mirasvit\Related\Service\AreaContext\RequestContext')->getProduct();
        $blockRepository = $objectManager->get('\Mirasvit\Related\Repository\BlockRepository');

        // if ($_SERVER['REMOTE_ADDR'] == '80.78.40.163') {
        //     print_r(get_class_methods($product));
        //     die();
        // }


        return $collection;
    }

    private function getNativeLinkedProductIds(array $productIds, RuleInterface $rule)
    {
        if (!$productIds) {
            return [];
        }

        // linkCodes = ['relation', 'up_sell', 'cross_sell'], see catalog_product_link_type table
        $linkCodes = [];
        if ($rule->getIsIncludeRelated()) {
            $linkCodes[] = 'relation';
        }
        if ($rule->getIsIncludeUpSells()) {
            $linkCodes[] = 'up_sell';
        }
        if ($rule->getIsIncludeCrossSells()) {
            $linkCodes[] = 'cross_sell';
        }

        if (!$linkCodes) {
            return [];
        }

        $connection = $this->resource->getConnection();
        $select     = $connection->select()->from(
            ['link' => $this->resource->getTableName('catalog_product_link')],
            ['linked_product_id']
        )->joinInner(
            ['type' => $this->resource->getTableName('catalog_product_link_type')],
            'link.link_type_id = type.link_type_id',
            []
        )->where('link.product_id IN(?)', $productIds
        )->where('type.code IN(?)', $linkCodes);

        return $connection->fetchCol($select);
    }
}
