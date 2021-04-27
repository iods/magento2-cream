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
use Magento\Framework\ObjectManagerInterface;

class Flag extends Base
{
    protected $tableFlag;
    public function __construct(Context $context, ObjectManagerInterface $objectManager)
    {
        parent::__construct($context, $objectManager);
        $this->tableFlag = $this->helperDb->getSqlTableName("flag");
    }

    public function getFlagState($flagCode = 0)
    {
        $state = 0;
        try {
            $state = (int) $this->getFlagFieldValueByCode($flagCode, "state");
        } catch (\Exception $e) {
            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
            $state = 0;
        } finally {
            return $state;
        }
    }

    protected function getFlagFieldValueById($flagId = 0, $fieldName = null)
    {
        try {
            $sql = "SELECT $fieldName FROM " . $this->tableFlag . " where flag_id = $flagId";
            $result = $this->helperDb->sqlQueryFetchOne($sql);
        } catch (\Exception $e) {
            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
            $result = null;
        } finally {
            return $result;
        }
    }

    protected function getFlagFieldValueByCode($flagCode = null, $fieldName = null)
    {
        try {
            $sql = "SELECT $fieldName FROM " . $this->tableFlag . " where flag_code LIKE '$flagCode'";
            $result = $this->helperDb->sqlQueryFetchOne($sql);
        } catch (\Exception $e) {
            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
            $result = null;
        } finally {
            return $result;
        }
    }
}
