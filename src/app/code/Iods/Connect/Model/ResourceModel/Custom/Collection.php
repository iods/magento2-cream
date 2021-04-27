<?php

namespace ViMagento\CustomApi\Model\ResourceModel\Custom;

/**
 * Class Collection
 * @package ViMagento\CustomApi\Model\ResourceModel\Custom
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(
            \ViMagento\CustomApi\Model\Custom::class,
            \ViMagento\CustomApi\Model\ResourceModel\Custom::class
        );
    }
}
