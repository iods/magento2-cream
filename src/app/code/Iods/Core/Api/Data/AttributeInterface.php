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

namespace Iods\Core\Api\Data;


interface AttributeInterface extends \Magento\Eav\Api\Data\AttributeInterface
{
    const VALUE                 = 'value';
    const VALUE_ID              = 'value_id';
    const IS_VISIBLE            = 'is_visible';
    const IS_WYSIWYG_ENABLED    = 'is_wysiwyg_enabled';
    const IS_USED_IN_GRID       = 'is_used_in_grid';
    const IS_VISIBLE_IN_GRID    = 'is_visible_in_grid';
    const IS_FILTERABLE_IN_GRID = 'is_filterable_in_grid';

    /**
     * @param int|bool $isVisible
     *
     * @return $this
     */
    public function setIsVisible($isVisible);

    /**
     * @return bool
     */
    public function getIsVisible();

    /**
     * @param int|bool $isWysiwygEnabled
     *
     * @return $this
     */
    public function setIsWysiwygEnabled($isWysiwygEnabled);

    /**
     * @return bool
     */
    public function getIsWysiwygEnabled();

    /**
     * @param int|bool $isUsedInGrid
     *
     * @return $this
     */
    public function setIsUsedInGrid($isUsedInGrid);

    /**
     * @return bool
     */
    public function getIsUsedInGrid();

    /**
     * @param int|bool $isVisibleInGrid
     *
     * @return $this
     */
    public function setIsVisibleInGrid($isVisibleInGrid);

    /**
     * @return bool
     */
    public function getIsVisibleInGrid();

    /**
     * @param int|bool $isFilterableInGrid
     *
     * @return $this
     */
    public function setIsFilterableInGrid($isFilterableInGrid);

    /**
     * @return bool
     */
    public function getIsFilterableInGrid();
}
