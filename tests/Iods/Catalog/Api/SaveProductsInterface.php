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

interface SaveProductsInterface {

    /**
     * Save magento products
     * @return string
     */
    public function save();

    /**
     * Update magento products
     * @return string
     */
    public function process();

}
