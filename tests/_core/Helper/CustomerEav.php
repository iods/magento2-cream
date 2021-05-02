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

class CustomerEav extends Eav
{

    public function getCustomerAttributeValue($customerId = 0, $attributeCode)
    {
        return $this->getAttributeValue("customer", $attributeCode, $customerId);
    }

    public function getCustomerEntityFieldValue($customerId = 0, $fieldName = null)
    {
        return $this->getEntityFieldValue("customer", $fieldName, $customerId);
    }

    public function getCustomerAttributeSelect($customerId = 0, $attributeCode = null)
    {
        return $this->getAttributeOptionValue((int) $this->getCustomerAttributeValue($customerId, $attributeCode));
    }
}
