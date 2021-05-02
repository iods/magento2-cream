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

namespace Iods\Core\Console\Command;

// How to iterate through pages of products in Magento 2 (specifically tested with version 2.3.5-p2) using a
// Product CollectionFactory. This specific example is for a console command that maintains that products that
// meet a certain set of criteria are in the Clearance category. It also happens to show how to include stock
// quantity information with the products.

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessClearanceItems extends Command
{
    const CLEARANCE_CATEGORY_NAME = 'Clearance';

    protected $categoryCollectionFactory;

    protected $categoryLink;

    protected $productCollectionFactory;

    protected $productLinkFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Api\CategoryLinkRepositoryInterface $categoryLink,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Api\Data\CategoryProductLinkInterfaceFactory $productLinkFactory
    )
    {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->categoryLink = $categoryLink;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productLinkFactory = $productLinkFactory;

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('company:process-clearance-items');
        $this->setDescription('Update the Clearance Category based on products in the system.');

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/clearance_category_update.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $categoryCollection = $this->categoryCollectionFactory
            ->create()
            ->addAttributeToFilter('name', self::CLEARANCE_CATEGORY_NAME)
            ->setPageSize(1)
        ;
        if ($categoryCollection->getSize())
        {
            $category = $categoryCollection->getFirstItem();
        }
        else
        {
            $output->writeln('<error>No Category with name "'.self::CLEARANCE_CATEGORY_NAME.'" found.</error>');
            exit;
        }
        $categoryId = $category->getId();

        // generate an array of products currently in the category
        $currentCategoryProductSkus = array();
        $products = $category->getProductCollection()->addAttributeToSelect('sku');
        foreach ($products as $product)
        {
            $currentCategoryProductSkus[] = $product->getSku();
        }

        // get all products, paged so as to be friendly on system resources
        $productCollection = $this->productCollectionFactory->create();
        $productCollection
            ->addFieldToFilter('type_id', ['eq' => 'simple'])
            ->addAttributeToSelect(['sku', 'discontinued', 'price', 'special_price'])
            ->joinField(
                'qty',
                'cataloginventory_stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1',
                'left'
            )
            ->setPageSize(100)
        ;
        $productsCount = $productCollection->getSize();
        $progressBar = new ProgressBar($output, $productsCount);
        $output->writeln('<info>Found ' . $productsCount . ' products</info>');

        // iterate through all products, adding clearance items to the category
        for ($currentPage = 1; $currentPage <= $productCollection->getLastPageNumber(); $currentPage++)
        {

            // the clear call is important and I was unable to find any examples including it
            // without it, the products in the collection will remain on page 1
            $productCollection->clear()->setCurPage($currentPage)->load();

            foreach ($productCollection as $product)
            {
                $progressBar->advance();

                $basePrice = $product->getPriceInfo()->getPrice('base_price')->getAmount()->getBaseAmount();
                $specialPrice = $product->getPriceInfo()->getPrice('special_price')->getAmount()->getBaseAmount();

                if (    $product->getDiscontinued()
                    && $product->getQty() > 0
                    && (    abs((float)$basePrice - (int)$basePrice - 0.88) < 0.0001
                        || abs((float)$specialPrice - (int)$specialPrice - 0.88) < 0.0001 ) )
                {
                    $sku = $product->getSku();

                    if (($key = array_search($sku, $currentCategoryProductSkus)) !== false)
                    {
                        // this sku was already in the category, we do not need to add it or remove it, so take it out of the array
                        unset($currentCategoryProductSkus[$key]);
                    }
                    else
                    {
                        try {
                            // add this sku to the clearance category
                            $categoryProductLink = $this->productLinkFactory->create();
                            $categoryProductLink->setSku($sku);
                            $categoryProductLink->setCategoryId($categoryId);
                            $categoryProductLink->setPosition(0);
                            $this->categoryLink->save($categoryProductLink);
                        }
                        catch (\Exception $e)
                        {
                            $logger->info('SKU = '. $sku . ' Error = ' . $e->getMessage());
                        }
                    }
                }
            }
        }

        // remove products from the category that are no longer available on clearance
        foreach($currentCategoryProductSkus as $sku)
        {
            $this->categoryLink->deleteByIds($categoryId, $sku);
        }

        $output->writeln('<info>Clearance Category Updated Successfully.</info>');
    }
}
