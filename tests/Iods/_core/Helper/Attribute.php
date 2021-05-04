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

namespace Iods\Core\Helper;

use Magento\Eav\Api\Data\AttributeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

class Attribute extends AbstractHelper
{

  const ATTRIBUTE_TYPE_PRODUCT = 'catalog_product';

  const OPTIONS_DIVIDER = ',';

  protected $_optionAddType = [
    'select',
    'multiselect',
    'swatch'
  ];

  protected $_notValidateAttribute = [
    'status', 'tax_class_id'
  ];

  protected $_loadedAttributes;

  protected $_eavConfig;

  protected $_optionManagement;

  protected $_optionFactory;


    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    private $resource;

    /**
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var array
     */
    private $selectAttributeCodes;

    /**
     * @var array
     */
    private $multiselectAttributeCodes;

    /**
     * Attribute constructor.
     *
     * @param \Magento\Framework\App\Helper\Context                        $context
     * @param \Magento\Framework\App\ResourceConnection                    $resource
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * For a specific attribute/object, returns array of stores IDs which have
     * an actual value saved in the database, in that store's scope. For non-static,
     * store-scoped or website-scoped attributes only. Otherwise returns empty array.
     *
     * @param \Magento\Eav\Model\Entity\Attribute\AbstractAttribute $attribute
     * @param \Magento\Framework\Model\AbstractModel                $object
     *
     * @return int[]
     */
    public function getStoreIdsHavingAttributeValue(
        \Magento\Eav\Model\Entity\Attribute\AbstractAttribute $attribute,
        \Magento\Framework\Model\AbstractModel $object
    ) {
        $result = [];
        if ($object->getId() && !$attribute->isStatic()) {
            $table       = $attribute->getBackendTable();
            $connection  = $this->resource->getConnection('core_read');
            $description = $connection->describeTable($table);
            if (isset($description['store_id'])) {
                $select = $connection->select()->from($table, 'store_id');
                $select->where(AttributeInterface::ATTRIBUTE_ID . ' = ?', $attribute->getAttributeId());
                $select->where($attribute->getEntityIdField() . ' = ?', $object->getId());
                $result = $connection->fetchCol($select);
            }
        }

        return $result;
    }

    /**
     * @param string|null $entityTypeCode
     *
     * @return array
     */
    public function getSelectAttributeCodes($entityTypeCode = null)
    {
        if ($this->selectAttributeCodes === null) {
            /** @var \Magento\Eav\Model\ResourceModel\Attribute\Collection $collection */
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('frontend_input', 'select');
            $collection->join(
                ['eav_entity_type_table' => $collection->getTable('eav_entity_type')],
                'main_table.entity_type_id = eav_entity_type_table.entity_type_id',
                'entity_type_id'
            );

            if ($entityTypeCode) {
                $collection->addFieldToFilter('eav_entity_type_table.entity_type_code', $entityTypeCode);
            }

            $this->selectAttributeCodes = $collection->getColumnValues('attribute_code');
        }

        return $this->selectAttributeCodes;
    }

    /**
     * @param string|null $entityTypeCode
     *
     * @return array
     */
    public function getMultiselectAttributeCodes($entityTypeCode = null)
    {
        if ($this->multiselectAttributeCodes === null) {
            /** @var \Magento\Eav\Model\ResourceModel\Attribute\Collection $collection */
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('frontend_input', 'multiselect');
            $collection->join(
                ['eav_entity_type_table' => $collection->getTable('eav_entity_type')],
                'main_table.entity_type_id = eav_entity_type_table.entity_type_id',
                'entity_type_id'
            );

            if ($entityTypeCode) {
                $collection->addFieldToFilter('eav_entity_type_table.entity_type_code', $entityTypeCode);
            }

            $this->multiselectAttributeCodes = $collection->getColumnValues('attribute_code');
        }

        return $this->multiselectAttributeCodes;
    }

  public function __construct(
    \Magento\Framework\App\Helper\Context $context,
    \Magento\Eav\Model\Config $eavConfig,

    \Magento\Eav\Api\AttributeOptionManagementInterface $optionManagement,
    \Magento\Eav\Api\Data\AttributeOptionInterfaceFactory $optionFactory

  ) {

    $this->_eavConfig = $eavConfig;
    $this->_optionManagement = $optionManagement;
    $this->_optionFactory = $optionFactory;

    parent::__construct($context);
  }

  public function getIsOptionAttribute($code) {
    if(in_array($code, $this->_notValidateAttribute)) {
      return false;
    }
    $attribute = $this->getAttributeByCode( $code );
    $attributeType = $attribute->getFrontendInput();
    if(in_array($attributeType, $this->_optionAddType)) {
      return true;
    }
  }

  public function getOptionIdsFromLabels($attributeCode, $labelsString) {
    $optionsLabelsToCreate = [];

    if($labelsString == '') {
      return '';
    }
    $newOptionsIdsArr = [];
    $attribute = $this->getAttributeByCode($attributeCode);
    $attrOptions    = $attribute->getSource()->getAllOptions();
    $labelsArr  = explode(self::OPTIONS_DIVIDER, $labelsString);
    $optionsLabelsToCreate = $labelsArr;
    foreach($labelsArr as $label) {
      $labelCheck = trim($label);
      foreach($attrOptions as $optionExists) {
        if($optionExists['label'] == $labelCheck) {
          $newOptionsIdsArr[] = (int)$optionExists['value'];
          $optionsLabelsToCreate = array_diff($optionsLabelsToCreate, array($label));
        }
      }
    }

    foreach($optionsLabelsToCreate as $label) {
      $newLabel = trim( $label );
      $newOptionsIdsArr[] = $this->addAttributeOption($attributeCode, $newLabel);
    }

    return implode(self::OPTIONS_DIVIDER, $newOptionsIdsArr);
  }

  public function getOptionFromLabel($attributeCode, $labelCheck) {

    $attribute = $this->getAttributeByCode($attributeCode);
    $attrOptions    = $attribute->getSource()->getAllOptions();

    foreach($attrOptions as $optionExists) {
      if($optionExists['label'] == $labelCheck) {
        $newOptionsIdsArr[] = (int)$optionExists['value'];
        return $labelCheck;
      }
    }

    $this->addAttributeOption($attributeCode, $labelCheck);

  }

  protected function addAttributeOption($attributeCode, $label) {
    $option = $this->_optionFactory->create();
    $option->setLabel($label);

    $this->_optionManagement->add(self::ATTRIBUTE_TYPE_PRODUCT, $attributeCode, $option);
    $items = $this->_optionManagement->getItems(self::ATTRIBUTE_TYPE_PRODUCT, $attributeCode);

    $attribute = $this->getAttributeByCode($attributeCode, true);
    foreach($attribute->getSource()->getAllOptions() as $_option) {
      if($_option['label'] == $label) {
        return $_option['value'];
      }
    }
  }

  public function getOptionValues($attributeCode, $optionsString) {

    if($optionsString == '') {
      return '';
    }
    $attribute = $this->getAttributeByCode($attributeCode);
    $optionsIdsArr  = explode(self::OPTIONS_DIVIDER, $optionsString);
    $attrOptions    = $attribute->getSource()->getAllOptions();
    $newOptionsArr  = [];
    foreach($optionsIdsArr as $optionId) {

      foreach($attrOptions as $optionExists) {
        if($optionExists['value'] == $optionId) {
          $newOptionsArr[] = (string)$optionExists['label'];
        }
      }

    }

    return implode(self::OPTIONS_DIVIDER, $newOptionsArr);
  }

  public function getAttributeByCode($attributeCode, $force_load = false) {
    if(isset($this->_loadedAttributes[$attributeCode]) && !$force_load) {
      return $this->_loadedAttributes[$attributeCode];
    }

    $this->_loadedAttributes[$attributeCode] = $this->_eavConfig->getAttribute(self::ATTRIBUTE_TYPE_PRODUCT, $attributeCode);
    return $this->_loadedAttributes[$attributeCode];
  }
}
