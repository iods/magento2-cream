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

class Internal extends \Magento\Framework\App\Helper\AbstractHelper
{
     protected $eavCustomerFields = [];
     protected $eavAddressFields = [];
    /**
     * Eav config Model
     *
     * @var \Magento\Eav\Model\Config
     */
    protected $eavConfigModel;

    /**
     * Eav Resource Model Attribute Collection
     *
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection
     */
    protected $eavAttributeCollections;

    /**
    * @param \Magento\Eav\Model\Config $eavConfigModel
    * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection $eavAttributeCollection
    */

	public function __construct(
        \Magento\Eav\Model\Config $eavConfigModel,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection $eavAttributeCollection,
        \Magento\Framework\App\Helper\Context $context

    ) {
        $this->eavConfigModel = $eavConfigModel;
        $this->eavAttributeCollections = $eavAttributeCollection;
        $this->setCustomerAndAddressFields();
        parent::__construct($context);
    }

    /**
     * Get EAV attributes collection filter by customer and customer_address
     *
     * @param string $type type of EAV attributes
     * @return collection of data
     */
    public function setCustomerAndAddressFields()
    {
        $addressEntityType = $this->eavConfigModel->getEntityType('customer_address');
        $customerEntityType = $this->eavConfigModel->getEntityType('customer');
        $entityTypeIds = [];
        $entityTypeIds[] = $customerEntityType->getEntityTypeId();
        $entityTypeIds[] = $addressEntityType->getEntityTypeId();

        $attributes = $this->eavAttributeCollections->addFieldToFilter('entity_type_id', array('in' => $entityTypeIds));

        $eavCustomerField = [];
        $eavAddressField = [];
       foreach ($attributes as $key => $attribute) {
            if ($attribute->getEntityTypeId() == 1) {
                $eavCustomerField[] = $attribute->getData();
            }else{
                $eavAddressField[] = $attribute->getData();
            }
        }
        $this->eavAddressFields =  $eavAddressField;
        $this->eavCustomerFields =  $eavCustomerField;
        //@TODO check missing documented @return
    }

	/**
     * Get EAV attributes collection filter by type param
     *
     * @param string $type type of EAV attributes
     * @return collection of data
     */
    public function getFields($type = 'customer_address')
    {
        if ($type == 'customer_address') {
            return $this->eavAddressFields;
        } else {
             return $this->eavCustomerFields;
        }
        //@TODO check missing documented @return
    }

    /**
     * Get System config values
     *
     * @param string path of system config field
     * @return string
     */
    public function getStoreConfig($valPath)
    {
        return $this->scopeConfig->getValue($valPath, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
