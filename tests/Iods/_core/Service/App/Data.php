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

namespace Iods\Core\Service\App;

use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Module\ModuleListInterface;

class Data
{
    /** Module supplier */
    const MODULE_SUPPLIER = 'Buckaroo';

    /** Module code */
    const MODULE_CODE = 'Buckaroo_Magento2';

    /** Version of Module */
    const BUCKAROO_VERSION = '1.34.0';

    /** @var ProductMetadataInterface */
    private $productMetadata;

    /** @var ModuleListInterface */
    private $moduleList;

    public function __construct(
        ProductMetadataInterface $productMetadata,
        ModuleListInterface $moduleList
    ) {
        $this->productMetadata = $productMetadata;
        $this->moduleList = $moduleList;
    }

    /**
     * @return array
     */
    public function get()
    {
        $platformData = $this->getPlatformData();
        $moduleData = $this->getModuleData();

        $softwareData = array_merge($platformData, $moduleData);

        return $softwareData;
    }

    /**
     * @return ProductMetadataInterface
     */
    public function getProductMetaData()
    {
        return $this->productMetadata;
    }

    /**
     * @return string
     */
    public function getModuleVersion()
    {
        return self::BUCKAROO_VERSION;
    }

    /**
     * @return array
     */
    private function getPlatformData()
    {
        $platformName = $this->getProductMetaData()->getName() . ' - ' . $this->getProductMetaData()->getEdition();

        $platformData = [
            'PlatformName' => $platformName,
            'PlatformVersion' => $this->productMetadata->getVersion()
        ];

        return $platformData;
    }

    /**
     * @return array
     */
    private function getModuleData()
    {
        $module = $this->moduleList->getOne(self::MODULE_CODE);

        $moduleData = [
            'ModuleSupplier'    => self::MODULE_SUPPLIER,
            'ModuleName'        => $module['name'],
            'ModuleVersion'     => $this->getModuleVersion()
        ];

        return $moduleData;
    }
}
