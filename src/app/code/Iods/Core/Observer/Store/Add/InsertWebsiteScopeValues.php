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

namespace Iods\Core\Observer\Store\Add;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaInterfaceFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Exception\NoSuchEntityException;

class InsertWebsiteScopeValues implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var AbstractEntity
     */
    private $resource;

    /**
     * @var SearchCriteriaInterfaceFactory
     */
    private $searchCriteriaFactory;

    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * InsertWebsiteScopeValues constructor.
     *
     * @param AbstractEntity                 $resource
     * @param SearchCriteriaInterfaceFactory $searchCriteriaFactory
     * @param AttributeRepositoryInterface   $attributeRepository
     */
    public function __construct(
        AbstractEntity $resource,
        SearchCriteriaInterfaceFactory $searchCriteriaFactory,
        AttributeRepositoryInterface $attributeRepository
    ) {
        $this->resource              = $resource;
        $this->searchCriteriaFactory = $searchCriteriaFactory;
        $this->attributeRepository   = $attributeRepository;
    }

    /**
     * After new store view is added, this observer inserts attribute value row
     * for any attributes that have website scope
     *
     * @param Observer $observer
     *
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $storeId = $observer->getEvent()->getStore()->getStoreId();
        if ($storeId) {
            /** @var SearchCriteriaInterface $searchCriteria */
            $searchCriteria = $this->searchCriteriaFactory->create();
            $attributes     = $this->attributeRepository->getList($searchCriteria);

            foreach ($attributes->getItems() as $attribute) {
                $this->resource->fillWebsiteValuesForAttribute(
                    $attribute->getAttributeCode(),
                    null,
                    $storeId
                );
            }
        }
    }
}
