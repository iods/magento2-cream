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

namespace Iods\Core\Ui\Component;

use MageModule\Core\Api\Data\AttributeInterface;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterface;

class Repository implements \MageModule\Core\Ui\Component\Listing\Attribute\RepositoryInterface
{
    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var string
     */
    private $entityTypeCode;

    /**
     * Repository constructor.
     *
     * @param AttributeRepositoryInterface $attributeRepository
     * @param SearchCriteriaBuilder        $searchCriteriaBuilder
     * @param string                       $entityTypeCode
     */
    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        $entityTypeCode
    ) {
        $this->attributeRepository   = $attributeRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->entityTypeCode        = $entityTypeCode;
    }

    /**
     * @return SearchResultsInterface
     */
    public function getList()
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(AttributeInterface::IS_USED_IN_GRID, 1)
            ->create();

        return $this->attributeRepository->getList($this->entityTypeCode, $searchCriteria);
    }
}
