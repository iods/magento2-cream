<?php

namespace ViMagento\CustomApi\Model;

use ViMagento\CustomApi\Api\Data\CustomInterface;
use ViMagento\CustomApi\Model\ResourceModel\Custom\Collection;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;

/**
 * Class CustomManagement
 * @package ViMagento\CustomApi\Model
 */
class CustomRepository implements \ViMagento\CustomApi\Api\CustomRepositoryInterface
{
    /**
     * @var \ViMagento\CustomApi\Model\CustomFactory
     */
    protected $customFactory;

    /**
     * @var ResourceModel\Custom
     */
    protected $customResource;

    /**
     * @var ResourceModel\Custom\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \ViMagento\CustomApi\Api\Data\CustomSearchResultInterfaceFactory
     */
    protected $searchResultInterfaceFactory;

    /**
     * CustomRepository constructor.
     * @param \ViMagento\CustomApi\Model\CustomFactory $customFactory
     * @param ResourceModel\Custom $customResource
     * @param ResourceModel\Custom\CollectionFactory $collectionFactory
     * @param \ViMagento\CustomApi\Api\Data\CustomSearchResultInterfaceFactory $searchResultInterfaceFactory
     */
    public function __construct(
        \ViMagento\CustomApi\Model\CustomFactory $customFactory,
        \ViMagento\CustomApi\Model\ResourceModel\Custom $customResource,
        \ViMagento\CustomApi\Model\ResourceModel\Custom\CollectionFactory $collectionFactory,
        \ViMagento\CustomApi\Api\Data\CustomSearchResultInterfaceFactory $searchResultInterfaceFactory
    ) {
        $this->customFactory = $customFactory;
        $this->customResource = $customResource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultInterfaceFactory = $searchResultInterfaceFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        $customModel = $this->customFactory->create();
        $this->customResource->load($customModel, $id);
        if (!$customModel->getEntityId()) {
            throw new NoSuchEntityException(__('Unable to find custom data with ID "%1"', $id));
        }
        return $customModel;
    }

    /**
     * {@inheritdoc}
     */
    public function save(CustomInterface $vimagento)
    {
        $this->customResource->save($vimagento);
        return $vimagento;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        try {
            $customModel = $this->customFactory->create();
            $this->customResource->load($customModel, $id);
            $this->customResource->delete($customModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return mixed
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
