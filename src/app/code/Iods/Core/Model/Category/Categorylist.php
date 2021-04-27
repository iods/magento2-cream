<?php

namespace Magestio\Core\Model\Category;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Option\ArrayInterface;
use Magento\Store\Model\StoreManagerInterface;

class CategoryList implements ArrayInterface
{

    /**
     * Store categories cache
     *
     * @var array
     */
    protected $_storeCategories;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * CategoryList constructor.
     * @param StoreManagerInterface $storeManager
     * @param CategoryFactory $categoryFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        CategoryFactory $categoryFactory,
        ScopeConfigInterface $scopeConfig,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->storeManager = $storeManager;
        $this->categoryFactory = $categoryFactory;
        $this->scopeConfig = $scopeConfig;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param bool $addEmpty
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function toOptionArray($addEmpty = true)
    {
        $options = [];
        if ($addEmpty) {
            $options[] = ['label' => __('-- Please Select a Category --'), 'value' => ''];
        }
        $processedCategories = [];
        foreach ($this->storeManager->getStores() as $store) {
            $rootCategoryId = $store->getRootCategoryId();
            if (!in_array($rootCategoryId, $processedCategories)) {
                $rootCategory = $this->categoryRepository->get($rootCategoryId, $store->getId());
                $options[] = ['label' => $rootCategory->getName(), 'value' => $rootCategoryId];
                $tree = $this->getStoreCategories($rootCategoryId, true, false, true);
                $this->tree($options, $tree, '--');
                $processedCategories[] = $rootCategoryId;
            }
        }
        return $options;
    }

    /**
     * @param int $rootCategoryId
     * @param bool $sorted
     * @param bool $asCollection
     * @param bool $toLoad
     * @return \Magento\Framework\Data\Tree\Node\Collection
     */
    private function getStoreCategories($rootCategoryId, $sorted, $asCollection, $toLoad)
    {
        $cacheKey = sprintf('%d-%d-%d-%d', $rootCategoryId, $sorted, $asCollection, $toLoad);

        if (!isset($this->_storeCategories[$cacheKey])) {
            $category = $this->categoryFactory->create();

            $recursionLevel = max(
                0,
                (int)$this->scopeConfig->getValue(
                    'catalog/navigation/max_depth',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            );
            $this->_storeCategories[$cacheKey] = $category->getCategories($rootCategoryId, $recursionLevel, $sorted, $asCollection, $toLoad);
        }
        return $this->_storeCategories[$cacheKey];
    }

    /**
     * @param array $options
     * @param \Magento\Framework\Data\Tree\Node\Collection $tree
     * @param string $indent
     */
    private function tree(&$options, $tree, $indent = '')
    {
        foreach ($tree as $item) {
            /** @var \Magento\Framework\Data\Tree\Node $item */
            $options[] = [
                'label' => $indent . $item->getName(),
                'value' => $item->getId()
            ];
            if ($item->getChildren() and count($item->getChildren()) > 0) {
                $this->tree($options, $item->getChildren(), $indent . '--');
            }
        }
    }
}
