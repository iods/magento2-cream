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

namespace Iods\Core\Plugin\Block;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config as AppConfig;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\Store;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    /**
     * @var State
     */
    protected $state;

    /**
     * @param State $state
     */
    public function __construct(State $state)
    {
        $this->state = $state;
    }

    /**
     * Disable CDN's in Admin
     */
    public function aroundGetValue(AppConfig $subject, callable $proceed,
        $path = null,
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    ) {
        if ($path == Store::XML_PATH_SECURE_BASE_MEDIA_URL ||
            $path == Store::XML_PATH_UNSECURE_BASE_MEDIA_URL
        ) {
            try {
                if($this->state->getAreaCode() == Area::AREA_ADMINHTML) {
                    return null;
                }
            } catch (LocalizedException $ex) {
                // ignore
            }
        }

        return $proceed($path, $scope, $scopeCode);
    }
}
