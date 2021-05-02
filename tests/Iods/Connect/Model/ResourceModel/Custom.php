<?php

namespace ViMagento\CustomApi\Model\ResourceModel;

/**
 * Class Custom
 * @package ViMagento\CustomApi\Model\ResourceModel
 */
class Custom extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('vimagento_custom_entity', 'entity_id');
    }
}
