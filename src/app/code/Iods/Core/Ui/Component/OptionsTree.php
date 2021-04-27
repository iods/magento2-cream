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

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @package Common\Base
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_base
 */
trait OptionsTree
{
    protected string $fieldParentId = 'parent_id';
    protected string $fieldTitle = 'title';
    protected string $fieldValue = 'id';

    /**
     * @param AbstractCollection $collection
     * @return array
     */
    protected function getOptionsTree($collection)
    {
        $itemGroups = [];
        foreach ($collection as $item) {
            /* @var $item AbstractModel */
            if (!isset($itemGroups[$item->getDataByKey($this->fieldParentId)])) {
                $itemGroups[$item->getDataByKey($this->fieldParentId)] = [];
            }
            $itemGroups[$item->getDataByKey($this->fieldParentId)][] = $item;
        }
        return array_merge(
            [['label' => '[ root ]', 'value' => 0]],
            $this->collectOptions($itemGroups)
        );
    }

    /**
     * @param AbstractModel $item
     * @param int           $level
     * @param bool          $isLast
     * @return string
     */
    protected function getOptionLabel($item, $level, $isLast)
    {
        return sprintf(
            ' %s %s (ID: %d)',
            str_repeat(html_entity_decode('&#160;', ENT_NOQUOTES, 'UTF-8'), $level * 4),
            $item->getDataByKey($this->fieldTitle),
            $item->getId()
        );
    }

    /**
     * @param array $itemGroups
     * @param int   $parentId
     * @param int   $level
     * @return array
     */
    protected function collectOptions($itemGroups, $parentId = 0, $level = 0)
    {
        $options = [];
        if (isset($itemGroups[$parentId])) {
            $level++;
            $lastIndex = count($itemGroups[$parentId]) - 1;
            foreach ($itemGroups[$parentId] as $i => $item) {
                $options[] = [
                    'label' => $this->getOptionLabel($item, $level, $lastIndex == $i),
                    'value' => $item->getDataByKey($this->fieldValue)
                ];
                if (isset($itemGroups[$parentId])) {
                    $options = array_merge($options, $this->collectOptions($itemGroups, $item->getId(), $level));
                }
            }
        }
        return $options;
    }
}
