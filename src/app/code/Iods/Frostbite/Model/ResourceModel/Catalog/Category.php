<?php

declare(strict_types=1);

namespace Xigen\CacheWarmer\Model\ResourceModel\Catalog;

use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Catalog\Model\ResourceModel\Category as ResourceModelCategory;
use Magento\CatalogUrlRewrite\Model\CategoryUrlRewriteGenerator;
use Magento\Framework\DataObject;
use Magento\Framework\DB\Select;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;

class Category extends AbstractDb
{
    /**
     * @var \Magento\Framework\DB\Select
     */
    protected $select;

    /**
     * @var array
     */
    protected $attributesCache = [];

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category
     */
    protected $categoryResource;

    /**
     * @var \Magento\Framework\EntityManager\MetadataPool
     */
    protected $metadataPool;

    /**
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\ResourceModel\Category $categoryResource
     * @param \Magento\Framework\EntityManager\MetadataPool $metadataPool
     * @param string $connectionName
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        ResourceModelCategory $categoryResource,
        MetadataPool $metadataPool,
        $connectionName = null
    ) {
        $this->storeManager = $storeManager;
        $this->categoryResource = $categoryResource;
        $this->metadataPool = $metadataPool;
        parent::__construct($context, $connectionName);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('catalog_category_entity', 'entity_id');
    }

    /**
     * Get category collection array
     * @param null|string|bool|int|\Magento\Store\Model\Store $storeId
     * @return array|bool
     */
    public function getCollection($storeId)
    {
        $categories = [];

        /* @var $store \Magento\Store\Model\Store */
        $store = $this->storeManager->getStore($storeId);

        if (!$store) {
            return false;
        }

        $connection = $this->getConnection();

        $this->select = $connection->select()->from(
            $this->getMainTable()
        )->where(
            $this->getIdFieldName() . '=?',
            $store->getRootCategoryId()
        );
        $categoryRow = $connection->fetchRow($this->select);

        if (!$categoryRow) {
            return false;
        }

        $this->select = $connection->select()->from(
            ['e' => $this->getMainTable()],
            [$this->getIdFieldName(), 'updated_at']
        )->joinLeft(
            ['url_rewrite' => $this->getTable('url_rewrite')],
            'e.entity_id = url_rewrite.entity_id AND url_rewrite.is_autogenerated = 1'
            . $connection->quoteInto(' AND url_rewrite.store_id = ?', $store->getId())
            . $connection->quoteInto(' AND url_rewrite.entity_type = ?', CategoryUrlRewriteGenerator::ENTITY_TYPE),
            ['url' => 'request_path']
        )->where(
            'e.path LIKE ?',
            $categoryRow['path'] . '/%'
        );

        $this->addFilter($storeId, 'is_active', 1);

        $query = $connection->query($this->select);
        while ($row = $query->fetch()) {
            $category = $this->prepareCategory($row);
            $categories[$category->getId()] = $category;
        }

        return $categories;
    }

    /**
     * Prepare category
     * @param array $categoryRow
     * @return \Magento\Framework\DataObject
     */
    protected function prepareCategory(array $categoryRow)
    {
        $category = new DataObject();
        $category->setId($categoryRow[$this->getIdFieldName()]);
        $categoryUrl = !empty($categoryRow['url']) ? $categoryRow['url'] : 'catalog/category/view/id/' .
            $category->getId();
        $category->setUrl($categoryUrl);
        $category->setUpdatedAt($categoryRow['updated_at']);
        return $category;
    }

    /**
     * Add attribute to filter
     * @param int $storeId
     * @param string $attributeCode
     * @param mixed $value
     * @param string $type
     * @return \Magento\Framework\DB\Select|bool
     */
    protected function addFilter($storeId, $attributeCode, $value, $type = '=')
    {
        $meta = $this->metadataPool->getMetadata(CategoryInterface::class);
        $linkField = $meta->getLinkField();

        if (!$this->select instanceof Select) {
            return false;
        }

        if (!isset($this->attributesCache[$attributeCode])) {
            $attribute = $this->categoryResource->getAttribute($attributeCode);

            $this->attributesCache[$attributeCode] = [
                'entity_type_id' => $attribute->getEntityTypeId(),
                'attribute_id' => $attribute->getId(),
                'table' => $attribute->getBackend()->getTable(),
                'is_global' => $attribute->getIsGlobal(),
                'backend_type' => $attribute->getBackendType(),
            ];
        }
        $attribute = $this->attributesCache[$attributeCode];

        switch ($type) {
            case '=':
                $conditionRule = '=?';
                break;
            case 'in':
                $conditionRule = ' IN(?)';
                break;
            default:
                return false;
        }

        if ($attribute['backend_type'] == 'static') {
            $this->select->where('e.' . $attributeCode . $conditionRule, $value);
        } else {
            $this->select->join(
                ['t1_' . $attributeCode => $attribute['table']],
                'e.' . $linkField . ' = t1_' . $attributeCode . '.' . $linkField .
                ' AND t1_' . $attributeCode . '.store_id = 0',
                []
            )->where(
                't1_' . $attributeCode . '.attribute_id=?',
                $attribute['attribute_id']
            );

            if ($attribute['is_global']) {
                $this->select->where('t1_' . $attributeCode . '.value' . $conditionRule, $value);
            } else {
                $ifCase = $this->getConnection()->getCheckSql(
                    't2_' . $attributeCode . '.value_id > 0',
                    't2_' . $attributeCode . '.value',
                    't1_' . $attributeCode . '.value'
                );
                $this->select->joinLeft(
                    ['t2_' . $attributeCode => $attribute['table']],
                    $this->getConnection()->quoteInto(
                        't1_' .
                        $attributeCode .
                        '.' . $linkField . ' = t2_' .
                        $attributeCode .
                        '.' . $linkField . ' AND t1_' .
                        $attributeCode .
                        '.attribute_id = t2_' .
                        $attributeCode .
                        '.attribute_id AND t2_' .
                        $attributeCode .
                        '.store_id=?',
                        $storeId
                    ),
                    []
                )->where(
                    '(' . $ifCase . ')' . $conditionRule,
                    $value
                );
            }
        }

        return $this->select;
    }
}