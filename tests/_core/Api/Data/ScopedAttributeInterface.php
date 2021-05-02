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

interface ScopedAttributeInterface extends \MageModule\Core\Api\Data\AttributeInterface
{
    const STORE_ID           = 'store_id';
    const IS_GLOBAL          = 'is_global';
    const SCOPE_STORE_TEXT   = 'store';
    const SCOPE_GLOBAL_TEXT  = 'global';
    const SCOPE_WEBSITE_TEXT = 'website';

    /**
     * @param string $scope
     *
     * @return $this
     */
    public function setScope($scope);

    /**
     * @return string|null
     */
    public function getScope();

    /**
     * @return bool
     */
    public function isScopeGlobal();

    /**
     * @return bool
     */
    public function isScopeWebsite();

    /**
     * @return bool
     */
    public function isScopeStore();
}
