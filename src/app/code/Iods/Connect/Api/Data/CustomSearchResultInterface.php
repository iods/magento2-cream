<?php

namespace ViMagento\CustomApi\Api\Data;

/**
 * Interface CustomSearchResultInterface
 * @package ViMagento\CustomApi\Api\Data
 */
interface CustomSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \ViMagento\CustomApi\Api\Data\CustomInterface[]
     */
    public function getItems();

    /**
     * @param \ViMagento\CustomApi\Api\Data\CustomInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
