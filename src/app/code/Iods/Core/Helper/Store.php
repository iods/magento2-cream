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
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;

class Store extends AbstractHelper
{

    private $storeManager;

    private $storeIdsByWebsiteId = [];


    public function __construct(
        StoreManagerInterface $storeManager,
        Context $context
    ) {
        parent::__construct($context);

        $this->storeManager = $storeManager;
    }

     // Allows to get store ids by website ID without breaking service contract
     //@param int|string $websiteId
     // @return array
    public function getStoreIdsByWebsiteId($websiteId)
    {
        if (!isset($this->storeIdsByWebsiteId[$websiteId])) {
            $this->storeIdsByWebsiteId[$websiteId] = [];

            $stores = $this->storeManager->getStores(false);

            /** @var StoreInterface $store */
            foreach ($stores as $store) {
                if ((int)$store->getWebsiteId() === (int)$websiteId) {
                    $this->storeIdsByWebsiteId[$websiteId][] = $store->getId();
                }
            }
        }

        return $this->storeIdsByWebsiteId[$websiteId];
    }
}
