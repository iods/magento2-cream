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

namespace Iods\Core\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 */
class Validate extends AbstractData
{
    const DEV_ENV = ['localhost', 'dev', '127.0.0.1', '192.168.', 'demo.'];

    /**
     * @var array
     */
    protected $configModulePath = [];

    /**
     * @var array
     */
    protected $_mageplazaModules;

    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    // protected $_moduleList;

    /**
     * Validate constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        ModuleListInterface $moduleList
    )
    {
        $this->_moduleList = $moduleList;

        parent::__construct($context, $objectManager, $storeManager);
    }

    /**
     * @param $moduleName
     * @return bool
     */
    public function needActive($moduleName)
    {
        $type = $this->getModuleType($moduleName);
        if (!$type || !in_array($type, ['1', '2'])) {
            return false;
        }

        return true;
    }

    /**
     * @param $moduleName
     * @return mixed
     */
    public function getModuleType($moduleName)
    {
        $configModulePath = $this->getConfigModulePath($moduleName);

        return $this->getConfigValue($configModulePath . '/module/type');
    }

    /**
     * @param $moduleName
     * @return bool
     */
    public function getConfigModulePath($moduleName)
    {
        if (!isset($this->configModulePath[$moduleName])) {
            $this->configModulePath[$moduleName] = false;

            $helperClassName = str_replace('_', '\\', $moduleName) . '\Helper\Data';
            if (class_exists($helperClassName)) {
                $helper = $this->objectManager->get($helperClassName);
                if ($helper instanceof AbstractData) {
                    $this->configModulePath[$moduleName] = $helper::CONFIG_MODULE_PATH;
                }
            }
        }

        return $this->configModulePath[$moduleName];
    }

    /**
     * @param $moduleName
     * @return bool
     */
    public function isModuleActive($moduleName)
    {
        $configModulePath = $this->getConfigModulePath($moduleName);

        return $this->getConfigValue($configModulePath . '/module/active')
            && $this->getConfigValue($configModulePath . '/module/product_key');
    }

    /**
     * @param $moduleName
     * @return array
     */
    public function getModuleCheckbox($moduleName)
    {
        $configModulePath = $this->getConfigModulePath($moduleName);

        $create = $this->getConfigValue($configModulePath . '/module/create');
        if (is_null($create)) {
            $create = 1;
        }

        $subscribe = $this->getConfigValue($configModulePath . '/module/subscribe');
        if (is_null($subscribe)) {
            $subscribe = 1;
        }

        return [
            'create' => (int)$create,
            'subscribe' => (int)$subscribe
        ];
    }

    /**
     * @return array
     */
    public function getModuleList()
    {
        if (is_null($this->_mageplazaModules)) {
            $this->_mageplazaModules = [];

            $allowList = true;
            $hostName = $this->_urlBuilder->getBaseUrl();
            foreach (self::DEV_ENV as $env) {
                if (strpos($hostName, $env) !== false) {
                    $allowList = false;
                    break;
                }
            }

            if ($allowList) {
                $moduleList = $this->_moduleList->getNames();
                foreach ($moduleList as $name) {
                    if (strpos($name, 'Iods_') === false) {
                        continue;
                    }

                    $this->_mageplazaModules[] = $name;
                }
            }
        }

        return $this->_mageplazaModules;
    }
}
