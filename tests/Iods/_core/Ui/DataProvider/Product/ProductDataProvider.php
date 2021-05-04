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

namespace Iods\Core\Ui\DataProvider\Product;

use Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider as DataProvider;
use Magento\Framework\Api\Filter;

/**
 * Class ProductDataProvider
 * @package Magestio\Core\Ui\DataProvider\Product
 */
class ProductDataProvider extends DataProvider
{
    public function addFilter(Filter $filter)
    {
        if ($filter->getField() == 'category_id') {
            $this->getCollection()->addCategoriesFilter(array('in' => $filter->getValue()));
        } elseif ($filter->getField() == 'sku_multiple') {

            // Remove % at the begin and end
            $value = $filter->getValue();
            $value = substr($value, 1, strlen($value) - 2);

            //
            $skus = explode(',', $value);
            $skus = array_map('trim', $skus);

            $filters = [];
            foreach ($skus as $sku) {
                $filters[] = ['attribute' => 'sku', 'like' => "%$sku%"];
            }

            $this->getCollection()->addFieldToFilter($filters);

        } elseif (isset($this->addFilterStrategies[$filter->getField()])) {
            $this->addFilterStrategies[$filter->getField()]
                ->addFilter(
                    $this->getCollection(),
                    $filter->getField(),
                    [$filter->getConditionType() => $filter->getValue()]
                );
        } else {
            parent::addFilter($filter);
        }
    }
}
