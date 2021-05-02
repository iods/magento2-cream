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

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Category
 * @package Magestio\Core\Ui\Component\Listing\Column
 */
class Category extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        $fieldName = $this->getData('name');
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $productId=$item['entity_id'];

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);
                $cats = $product->getCategoryIds();

                $categories=[];
                if (count($cats)) {
                    foreach ($cats as $cat) {
                        $category = $objectManager->create('Magento\Catalog\Model\Category')->load($cat);
                        $categories[]=$category->getName();
                    }
                }
                $item[$fieldName] = implode(', ', $categories);
            }
        }
        return $dataSource;
    }
}
