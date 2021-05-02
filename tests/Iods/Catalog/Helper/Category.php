<?php
namespace Namespacename\Modulename\Helper;

use Magento\Catalog\Model\Indexer\Category\Product\TableMaintainer;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Helper\AbstractHelper;
class CategoryHelper extends AbstractHelper
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollectionFactory;
    /**
     * @var TableMaintainer
     */
    private $tableMaintainer;
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * CategoryHelper constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param TableMaintainer|null $tableMaintainer
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        TableMaintainer $tableMaintainer = null
    )
    {
        parent::__construct($context);
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->_storeManager = $storeManager;
        $this->tableMaintainer = $tableMaintainer ?: ObjectManager::getInstance()->get(TableMaintainer::class);

    }

    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    public function getCategoryCollectionWithProductCount()
    {
        $categoryCollection = $this->categoryCollectionFactory->create();
        $select = $categoryCollection->getSelect();
        $select->joinLeft(
            ['cat_index' => $this->tableMaintainer->getMainTable($this->getStoreId())],
            'cat_index.category_id=e.entity_id',
            ['product_count' => 'COUNT(DISTINCT cat_index.product_id)']
        )->group('e.entity_id');
        return $categoryCollection;
    }
}


/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-seo
 * @version   2.1.8
 * @copyright Copyright (C) 2021 Mirasvit (https://mirasvit.com/)
 */


namespace Mirasvit\SeoSitemap\Block\Map;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Mirasvit\SeoSitemap\Helper\Data as SeoSitemapData;
use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template;
use Mirasvit\SeoSitemap\Model\Config;

class Category extends Template
{
    /**
     * @var CategoryCollectionFactory
     */
    private $categoryCollectionFactory;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Template\Context
     */
    private $context;

    /**
     * @var \Magento\Catalog\Model\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var SeoSitemapData
     */
    private $seoSitemapData;

    /**
     * Category constructor.
     *
     * @param Template\Context $context
     * @param CategoryCollectionFactory $categoryCollectionFactory
     * @param \Magento\Catalog\Model\CategoryRepository $categoryRepository
     * @param SeoSitemapData $seoSitemapData
     * @param Config $config
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CategoryCollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        SeoSitemapData $seoSitemapData,
        Config $config,
        array $data = []
    )
    {
        $this->context = $context;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->categoryRepository = $categoryRepository;
        $this->seoSitemapData = $seoSitemapData;
        $this->config = $config;

        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return __('Categories');
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCategoryCollection()
    {
        return $this->categoryCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('is_active', 1)
            ->setStore($this->context->getStoreManager()->getStore());
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCategoriesAsPaths()
    {
        $activeCategories = $this->getCategoryCollection();
        $activeCategoriesIds = $activeCategories->getAllIds();
        $categoriesPath = [];

        foreach ($activeCategories as $category) {
            $categoryIds = explode('/', $category->getPath());
            $categoryPath = [];

            foreach ($categoryIds as $categoryId) {
                $categoryName = false;

                if (!in_array($categoryId, $activeCategoriesIds)) {
                    continue;
                }

                $categoryName = $this->getCategoryName($categoryId);

                if (!$this->validate($category->getUrl(), $categoryName)) {
                    continue;
                }

                $categoryPath[] = $categoryName;
            }

            $categoriesPath[] = new DataObject([
                'path' => $categoryPath,
                'url' => $category->getUrl(),
            ]);
        }

        return $categoriesPath;
    }

    /**
     * @param int $categoryId
     *
     * @return false|string|null
     */
    private function getCategoryName($categoryId)
    {
        try {
            $category = $this->categoryRepository->get($categoryId);
        } catch (\Exception $e) {
            return false;
        }

        return $category->getName();
    }

    /**
     * @param string $categoryUrl
     * @param false|string $categoryName
     *
     * @return bool
     */
    private function validate($categoryUrl, $categoryName = false)
    {
        if ($this->seoSitemapData->checkIsUrlExcluded($categoryUrl)) {
            return false;
        }

        if (!$categoryName || $categoryName == 'Root Catalog' || $categoryName == 'Default Category' || $categoryName == 'Categories') {
            return false;
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function isShowCategories()
    {
        return $this->config->getIsShowCategories();
    }
}
