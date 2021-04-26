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

use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\Store;
use Magento\Eav\Api\Data\AttributeInterface;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Option
 *
 * @package MageModule\Core\Helper\Eav\Attribute
 */
class AttributeOption extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * @var AttributeInterface
     */
    private $attributes = [];

    /**
     * @var array
     */
    private $attributeOptions = [];

    /**
     * Option constructor.
     *
     * @param Context                      $context
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        Context $context,
        AttributeRepositoryInterface $attributeRepository
    ) {
        parent::__construct($context);
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @param string $entityTypeCode
     * @param string $attrCode
     *
     * @return AttributeInterface
     * @throws NoSuchEntityException
     */
    private function getAttribute($entityTypeCode, $attrCode)
    {
        $key = $entityTypeCode . '-' . $attrCode;
        if (!isset($this->attributes[$key])) {
            $this->attributes[$key] = $this->attributeRepository->get($entityTypeCode, $attrCode);
        }

        return $this->attributes[$key];
    }

    /**
     * @param string $entityTypeCode
     * @param string $attrCode
     * @param int    $storeId
     *
     * @return array
     */
    private function getAttributeOptions($entityTypeCode, $attrCode, $storeId = Store::DEFAULT_STORE_ID)
    {
        $key = $entityTypeCode . '-' . $attrCode . '-' . $storeId;
        if (!isset($this->attributeOptions[$key])) {
            $this->attributeOptions[$key] = [];

            try {
                $attribute = $this->getAttribute($entityTypeCode, $attrCode);
                if ($attribute instanceof \Magento\Eav\Model\Entity\Attribute\AbstractAttribute &&
                    $attribute->usesSource()
                ) {
                    $attribute->setStoreId($storeId);
                    $options = $attribute->getSource()->getAllOptions();
                    foreach ($options as $option) {
                        if (!isset($option['value']) || $option['value'] === '') {
                            continue;
                        }

                        $this->attributeOptions[$key][$option['value']] = trim(strtolower($option['label']));
                    }
                }
            } catch (\Exception $e) {}
        }

        return $this->attributeOptions[$key];
    }

    /**
     * @param string $entityTypeCode
     * @param string $attrCode
     * @param string $label
     * @param int    $storeId
     *
     * @return false|int|null|string
     */
    public function getAttributeOptionIdByLabel($entityTypeCode, $attrCode, $label, $storeId = Store::DEFAULT_STORE_ID)
    {
        $label    = trim(strtolower($label));
        $options  = $this->getAttributeOptions($entityTypeCode, $attrCode, $storeId);
        $optionId = array_search($label, $options);

        return $optionId !== false ? $optionId : null;
    }
}
