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
use Magento\Framework\ObjectManagerInterface;


class Base extends AbstractHelper
{
    protected $_objectManager;

    protected $_dbHelper;

    protected $_logHelper;

    protected $_fileHelper;

    protected $_dateHelper;

    protected $_urlHelper;

    public function __construct(Context $context, ObjectManagerInterface $objectManager)
    {
        $this->_dbHelper = $this->generateClassObject(Db::class);
        $this->_logHelper = $this->generateCLassObject(Log::class);

        parent::__construct($context, $objectManager);
    }

    public function getDbHelper()
    {
        return $this->_dbHelper;
    }

    public function getLogHelper()
    {
        return $this->_logHelper;
    }
}
