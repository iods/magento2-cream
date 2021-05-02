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

class ProductEav extends Eav
{

    public function getProductAttributeValue($productId = 0, $attributeCode)
    {
        return $this->getAttributeValue("catalog_product", $attributeCode, $productId);
    }

    public function getProductEntityFieldValue($productId = 0, $fieldName = null)
    {
        return $this->getEntityFieldValue("catalog_product", $fieldName, $productId);
    }

    public function getProductAttributeSelect($productId = 0, $attributeCode = null)
    {
        return $this->getAttributeOptionValue((int) $this->getProductAttributeValue($productId, $attributeCode));
    }
}
