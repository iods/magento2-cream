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
use Magento\Framework\Logger\Handler\Base;
use Magento\Framework\Logger\Monolog;
use Magento\Framework\ObjectManagerInterface;

class Logger extends AbstractHelper
{
    private ObjectManagerInterface $objectManager;
    private array $loggers = [];

    /**
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param $fileName
     * @return Monolog
     */
    private function getLogger($fileName)
    {
        if (!isset($this->loggers[$fileName])) {
            $this->loggers[$fileName] = $this->objectManager->create(
                Monolog::class,
                ['handlers' => ['debug' => $this->objectManager->create(Base::class, ['fileName' => $fileName])]]
            );
        }
        return $this->loggers[$fileName];
    }

    /**
     * @param mixed  $data
     * @param string $fileName
     */
    public function log($data, $fileName = 'system.log')
    {
        $this->getLogger('/var/log/' . $fileName)->addDebug(print_r($data, true));
    }

    protected $customLogger;

    public function __construct(
        \Psr\Log\LoggerInterface $customLogger
    ) {

        $this->customLogger = $customLogger;
    }

    /**
     * @param $obj
     */
    public function writeLog($obj) {
        if (is_string($obj)) {
            $this->customLogger->debug($obj);
        } else {
            $this->customLogger->debug(json_encode($obj));
        }
    }


    public function printLog($filename = null, $message = null)
    {
        return $this->writeLogEntry($filename, $message);
    }

    public function errorLog($method = null, $message = null)
    {
        return $this->printLog("hapex_error_log", "$method :: $message");
    }

    private function writeLogEntry($filename = null, $message = null)
    {
        try {
            $currentDate = $this->objectManager->get(DateHelper::class)->getCurrentDate()->format("Y-m-d h:i:s A T");
            $filePath = $this->objectManager->get(FileHelper::class)->getRootPath() . "/var/log/$filename.log";
            return error_log("[$currentDate] " . $message . "\n", 3, $filePath);;
        } catch (\Exception $e) {
            return false;
        }
    }
}
