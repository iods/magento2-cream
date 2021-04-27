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
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Import
 * @package ElTiempo\SapProducts\Cron
 */
class Import
{
    /**
     * CRON CONFIGURATIONS
     */
    const XML_CRON_ENABLE = 'jobs/cron_product_import/active';
    const XML_CRON_ATTEMPTS_NUMBER = 'jobs/cron_product_import/attempts_number';
    const XML_CRON_ATTEMPT_TIME = 'jobs/cron_product_import/attempt_time';

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ProductHelper
     */
    protected $productHelper;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var WebService
     */
    protected $webService;

    /**
     * Import constructor
     *
     * @param LoggerInterface $logger
     * @param ProductHelper $productHelper
     * @param ScopeConfigInterface $scopeConfig
     * @param WebService $webService
     */
    public function __construct(
        LoggerInterface $logger,
        ProductHelper $productHelper,
        ScopeConfigInterface $scopeConfig,
        WebService $webService
    )
    {
        $this->logger = $logger;
        $this->productHelper = $productHelper;
        $this->scopeConfig = $scopeConfig;
        $this->webService = $webService;
    }

    /**
     * Create or Update Products in Magento from SAP Product Web Service
     *
     * @return bool
     */
    public function execute()
    {
        $scopeStore = ScopeInterface::SCOPE_STORE;
        $attempts = $this->scopeConfig->getValue(self::XML_CRON_ATTEMPTS_NUMBER, $scopeStore);
        $attemptTime = $this->scopeConfig->getValue(self::XML_CRON_ATTEMPT_TIME, $scopeStore);
        $active = $this->scopeConfig->getValue(self::XML_CRON_ENABLE, $scopeStore);

        if ($active) {
            do {
                $sapProductData = $this->webService->getProducts();

                if ($this->webService->getException()) {
                    $attempts--;
                } else {
                    if (count($sapProductData) > 0) {
                        foreach ($sapProductData as $sapProduct) {
                            if ($this->productHelper->skuExists($sapProduct->CODIGOPRODUCTO)) {
                                $this->productHelper->updateProduct($sapProduct);
                            } else {
                                $this->productHelper->createNewProduct($sapProduct);
                            }
                        }
                    }

                    return true;
                }

                sleep($attemptTime);
            } while ($attempts > 0);
            //TODO: Send Email.
        }
    }
}
