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

namespace Iods\Core\Api;

interface AttributeRepositoryInterface
{

    /**
     * Get all attributes as codes
     * @return string
     */
    public function all();

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param string $attributeCode
     *
     * @return \MageModule\Core\Api\Data\AttributeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($attributeCode);

    /**
     * @param \MageModule\Core\Api\Data\AttributeInterface $attribute
     *
     * @return \MageModule\Core\Api\Data\AttributeInterface
     * @throws \Magento\Framework\Exception\StateException
     */
    public function save(\MageModule\Core\Api\Data\AttributeInterface $attribute);

    /**
     * @param \MageModule\Core\Api\Data\AttributeInterface $attribute
     *
     * @return bool
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\MageModule\Core\Api\Data\AttributeInterface $attribute);

    /**
     * @param string $attributeCode
     *
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($attributeCode);
}
