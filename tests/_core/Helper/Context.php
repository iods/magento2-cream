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

use Iods\Core\Helper\Log;
use Magento\Framework\HTTP\Adapter\CurlFactory;

class Context
{
    protected CurlFactory $curlFactory;
    private Logger $logger;

    public function __construct(
        CurlFactory $curlFactory,
        Logger $logger
    ) {
        $this->curlFactory = $curlFactory;
        $this->logger = $logger;
    }

    /**
     * @return CurlFactory
     */
    public function getCurlFactory()
    {
        return $this->curlFactory;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }
}
