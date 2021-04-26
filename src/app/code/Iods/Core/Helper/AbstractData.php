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

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Tests\NamingConvention\true\bool;
use Magento\Tests\NamingConvention\true\string;

abstract class AbstractData extends AbstractHelper
{
    const MODULE_NAME = 'Iods_Core';
    const MODULE_PATH = 'iods';

    const MODULE_ENABLE_ADDONS = false;
    const MODULE_ENABLE_DEBUG = false;

    private ComponentRegistrarInterface $componentRegistrarInterface;

    /**
     * @type array
     * @var  $_data
     */
    protected array $_data;

    protected ModuleListInterface $_moduleList;

    /**
     * @var ObjectManagerInterface $objectManager
     */
    protected ObjectManagerInterface $_objectManager;

    /** @var StoreManagerInterface $storeManager */
    protected StoreManagerInterface $_storeManager;

    public function __construct(
        Context $context,
        ComponentRegistrarInterface $componentRegistrarInterface,
        ModuleListInterface $moduleList,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager
    ) {
        $this->componentRegistrarInterface = $componentRegistrarInterface;
        $this->_moduleList = $moduleList;
        $this->_objectManager = $objectManager;
        $this->_storeManager = $storeManager;

        parent::__construct($context);
    }

    // check to see if it is enabled
    public function isEnabled($storeId = null)
    {
        return $this->getConfigGeneral('enabled', $storeId);
    }

    // pull in a config flag
    public function getConfigFlag($field = null, $storeId = null): bool
    {
        $isSetFlag = false;
        try {
            $isSetFlag = $this->scopeConfig->isSetFlag($field, ScopeInterface::SCOPE_STORE, $storeId);
        } catch (\Exception $e) {
            // $this->helperLog->errorLog(__METHOD__, $e->getMessage());
            $isSetFlag = false;
        } finally {
            return $isSetFlag;
        }
    }

    // get the config value from the store
    public function getConfigValue($field, $storeId = null)
    {
        // @TODO does this need to be more specific (store specific on the call)
        if ($storeId == null) {
            $storeId = $this->getStoreId();
        }

        return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getVal($section, $code, $storeId = null)
    {
        if ($storeId == null) {
            $storeId = $this->getStoreId();
        }

        return $this->getConfigValue($this->getModuleCode() . $section . '/' . $code, $storeId);
    }

    // return a store config value from the general section
    public function getConfigGeneral($code = '', $storeId = null)
    {
        $code = ($code !== '') ? '/' . $code : '';

        return $this->getConfigValue(static::MODULE_PATH . '/general' . $code, $storeId);
    }


    public function getModuleCode(): string
    {
        return static::MODULE_PATH;
    }

    // return a store config value from a specific field
    public function getModuleConfig($field = '', $storeId = null)
    {
        $field = ($field !== '') ? '/' . $field : '';

        return $this->getConfigValue(static::MODULE_PATH . $field, $storeId);
    }

    public function getStoreId(): int
    {
        return $this->_storeManager->getStore()->getId();
    }

    public function getStoreUrl(): string
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getWebsiteId(): int
    {
        return $this->_storeManager->getStore()->getWebsiteId();
    }


    /**
     * Takes a multidimensional array and makes sure that all subarrays have the exact same keys
     */
    public function equalizeArrayKeys(array &$array)
    {
        /** note to self: using nested for each to ensure that numeric array keys are preserved */

        $fields = [];
        foreach ($array as &$subarray) {
            foreach ($subarray as $key => $value) {
                $fields[$key] = null;
            }
        }

        foreach ($array as &$subarray) {
            $newData = $fields;
            foreach ($fields as $field => $null) {
                if (isset($subarray[$field])) {
                    $newData[$field] = $subarray[$field];
                }
            }
            $subarray = $newData;
            $newData  = null;
        }
    }


    /**
     * Takes the array keys from the first element in array and adds them as the first
     * subarray to create csv headers row. $this->equalizeArrayKeys() should be run first
     */
    public function addHeadersRowToArray(array &$array)
    {
        reset($array);
        $row = current($array);
        if ($row) {
            $fields = array_keys($row);
            array_unshift($array, $fields);
        }
    }
    protected function getArrayValue($arr = [], $index = 0, $default = null): mixed
    {
        return $arr[$index] ?? $default;
    }


    /**
     * Adds prefix to all array keys or \Magento\Framework\DataObject keys
     */
    public function addPrefix($prefix, &$item)
    {
        $isObject = $item instanceof \Magento\Framework\DataObject;
        $array    = $isObject ? $item->getData() : $item;

        $newArray = [];
        foreach ($array as $key => &$value) {
            $newArray[$prefix . $key] = $value;
        }

        $array = $newArray;

        if ($isObject) {
            $item->setData($array);
        } else {
            $item = $array;
        }
    }








    public function getVersion($version = null)
    {
        return $version == null ? 'N/A' : $this->_moduleList->getOne(self::MODULE_NAME)['setup_version'];
    }

    public function getModuleVersion(): string
    {
        $dir =  $this->componentRegistrarInterface->getPath(componentRegistrar::MODULE, self::MODULE_NAME);

        $data = file_get_contents($dir . '/composer.json');
        $data = json_decode($data, true);

        if (empty($datap['version'])) {
            return 'Developing a new version. Stay tuned.';
        }

        return $data['version'];
    }







    public function getIsAddonEnabled()
    {
        return $this->scopeConfig->getValue(self::MODULE_ENABLE_ADDONS, ScopeInterface::SCOPE_STORE);
    }

    public function getIsDebugEnabled()
    {
        return $this->scopeConfig->getValue(self::MODULE_ENABLE_DEBUG, ScopeInterface::SCOPE_STORE);
    }







    public function createObject($path, array $arguments)
    {
        return $this->_objectManager->create($path, $arguments);
    }

    public function generateClassObject($class = null): mixed
    {
        try {
            $obj = $this->_objectManager->get($class);
        } catch (\Exception) {
            $obj = $this->_objectManager->create(DataObject::class);
        } finally {
            return $obj;
        }
    }

    // return an object
    public function getObject($path)
    {
        return $this->_objectManager->get($path);
    }








    // set some data (magic methods)
    public function setData($name, $value): static
    {
        $this->_data[$name] = $value;

        return $this;
    }

    // get some data from anywhere
    public function getData($name)
    {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }

        return null;
    }













    // remove all boolean false data
    public function removeFalse(array &$arr)
    {
        $arr = array_filter($arr,
            function ($value) {
                return $value !== false;
            });
    }

    // removes all boolean true
    public function removeTrue(array &$arr)
    {
        $arr = array_filter($arr,
            function ($value) {
                return $value !== true;
            });
    } // filters out the true, removing true and only returning false

    public function removeObjects(array &$array)
    {
        $array = array_filter(
            $array,
            function ($value) {
                return !is_object($value);
            }
        );
    }

    public function removeArrays(array &$array)
    {
        $array = array_filter(
            $array,
            function ($value) {
                return !is_object($value) && !is_array($value);
            }
        );
    }

    public function removeElements(array &$array, array $keys)
    {
        foreach (array_keys($array) as $key) {
            if (in_array($key, $keys)) {
                unset($array[$key]);
            }
        }
    }






    /**
     * Similar to PHP's native 'empty' but 0 is not considered an empty value
     *
     * @param string|int|float|bool|null|array $value
     *
     * @return bool
     */
    public function isEmpty($value)
    {
        return ($value === null || $value === false || $value === '') ||
            (is_array($value) && empty($value));
    }

    /**
     * @param string|int|float|bool|null|array $value
     *
     * @return bool
     */
    public function isNotEmpty($value)
    {
        return !$this->isEmpty($value);
    }




    // nullify empty strings
    public function nullifyEmptyString(array &$arr)
    {
        $arr = array_map(function ($value) {
            if (!is_array($value) && !is_object($value) && $value === '') {
                $value = null;
            }
            return $value;
        }, $arr);
    }

    public function sendOutput($output = null): bool
    {
        try {
            print_r($output);
            return true;
        } catch (\Exception) {
            // @TODO get this in w/ Bunyan
            return false;
        }
    }
}
