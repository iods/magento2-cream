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

namespace Iods\Core\Ui\Component\Store;

use Magento\Store\Ui\Component\Listing\Column\Store\Options as StoreOptions;

/**
 * @package Common\Base
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_base
 */
class Options extends StoreOptions
{
    public const ALL_STORE_VIEWS = '0';

    /**
     * @inheritDoc
     */
    protected function generateCurrentOptions()
    {
        $this->currentOptions['All Store Views'] = [
            'label' => __('All Store Views'),
            'value' => self::ALL_STORE_VIEWS
        ];
        parent::generateCurrentOptions();
    }
}
