<?php

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
     * @param Template\Context                          $context
     * @param CategoryCollectionFactory                 $categoryCollectionFactory
     * @param \Magento\Catalog\Model\CategoryRepository $categoryRepository
     * @param SeoSitemapData                            $seoSitemapData
     * @param Config                                    $config
     * @param array                                     $data
     */
    public function __construct(
        Template\Context $context,
        CategoryCollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        SeoSitemapData $seoSitemapData,
        Config $config,
        array $data = []
    ) {
        $this->context                   = $context;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->categoryRepository        = $categoryRepository;
        $this->seoSitemapData            = $seoSitemapData;
        $this->config                    = $config;

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

                try {
                    $categoryName = $this->getCategoryNameById($categoryId);
                } catch (\Exception $e) {
                    $e->getMessage();
                    continue 2;
                }

                if (!$categoryName) {
                    continue 2;
                }

                if ($categoryName == 'Root Catalog' || $categoryName == 'Default Category') {
                    continue;
                }

                $categoryPath[] = $categoryName;
            }

            if (!$categoryPath) {
                continue;
            }

            if ($this->seoSitemapData->checkIsUrlExcluded($category->getUrl())) {
                continue;
            }

            $categoriesPath[] = new DataObject([
                'path' => $categoryPath,
                'url'  => $category->getUrl(),
            ]);
        }

        return $categoriesPath;
    }

    /**
     * @param int $categoryId
     *
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getCategoryNameById($categoryId)
    {
        $category = $this->categoryRepository->get($categoryId);

        return $category->getName();
    }

    /**
     * @return mixed
     */
    public function isShowCategories()
    {
        return $this->config->getIsShowCategories();
    }
}
