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

use MageModule\Core\Model\ResourceModel\Entity\ScopedAttribute\WebsiteValuesSynchronizer;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface as MageScopedAttributeInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;

/**
 * Class SynchronizeWebsiteScopeValues
 *
 * @package MageModule\Core\Observer\Store\Add
 */
class SynchronizeWebsiteScopeValues implements ObserverInterface
{
    /**
     * @var WebsiteValuesSynchronizer
     */
    private $synchronizer;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * InsertWebsiteScopeValues constructor.
     *
     * @param WebsiteValuesSynchronizer    $synchronizer
     * @param SearchCriteriaBuilder        $searchCriteriaBuilder
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        WebsiteValuesSynchronizer $synchronizer,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        AttributeRepositoryInterface $attributeRepository
    ) {
        $this->synchronizer          = $synchronizer;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->attributeRepository   = $attributeRepository;
    }

    /**
     * @param Observer $observer
     *
     * @throws \Exception
     */
    public function execute(Observer $observer)
    {
        $store = $observer->getEvent()->getStore();
        if ($store instanceof StoreInterface) {
            if ($store->getId() > Store::DEFAULT_STORE_ID) {
                $this->searchCriteriaBuilder->addFilter(
                    ScopedAttributeInterface::IS_GLOBAL,
                    MageScopedAttributeInterface::SCOPE_WEBSITE
                );

                $list = $this->attributeRepository->getList($this->searchCriteriaBuilder->create());

                /** @var ScopedAttributeInterface $attribute */
                foreach ($list->getItems() as $attribute) {
                    $this->synchronizer->synchronize($attribute, $store->getWebsiteId());
                }
            }
        }
    }
}
