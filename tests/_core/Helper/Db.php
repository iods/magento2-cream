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
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\ObjectManagerInterface;

class Db extends AbstractHelper
{
    protected $resource;
    protected $helperLog;

    public function __construct(Context $context, ObjectManagerInterface $objectManager, ResourceConnection $resource, LogHelper $helperLog)
    {
        parent::__construct($context, $objectManager);
        $this->resource = $resource;
        $this->helperLog = $helperLog;
    }

    public function getSqlTableName($name = null)
    {
        $tableName = null;
        $tableExists = false;
        try {
            $tableName = $this->resource->getTableName($name);
            $tableExists = $this->resource->getConnection()->isTableExists($tableName);
        } catch (\Exception $e) {
            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
            $tableName = null;
            $tableExists = false;
        } finally {
            return $tableExists ? $tableName : null;
        }
    }

    public function sqlQuery($sql)
    {
        $result = null;
        try {
            $result = $this->resource->getConnection()->query($sql);
        } catch (\Exception $e) {
            $result = null;
            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
        } finally {
            return $result;
        }
    }

    public function sqlQueryFetchAll($sql, $limit = 0)
    {
        $sql .= ($limit > 0) ? " LIMIT $limit" : "";
        $result = null;
        try {
            $result = $this->resource->getConnection()->fetchAll($sql);
        } catch (\Exception $e) {
            $result = null;
            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
        } finally {
            return $result;
        }
    }

    public function sqlQueryFetchOne($sql)
    {
        $result = null;
        try {
            $result = $this->resource->getConnection()->fetchOne($sql);
        } catch (\Exception $e) {
            $result = null;
            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
        } finally {
            return $result;
        }
    }

    public function sqlQueryFetchRow($sql)
    {
        $result = null;
        try {
            $result = $this->resource->getConnection()->fetchRow($sql);
        } catch (\Exception $e) {
            $result = null;
            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
        } finally {
            return $result;
        }
    }
}
