<?php
/**
 * Iods Core for Magento 2
 *
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade the modules
 * in the Darkstar Magento 2 Suite to newer versions in the future.
 *
 * @category  Iods
 * @package   Iods\Core
 * @version   1.1.1
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2020, Rye Miller (http://ryemiller.io)
 * @license   MIT (https://en.wikipedia.org/wiki/MIT_License)
 */
declare(strict_types=1);

namespace Iods\Core\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Config\Block\System\Config\Form\Fieldset;
use Magento\Cron\Model\ResourceModel\Schedule\CollectionFactory;
use Magento\Framework\App\DeploymentConfig\Reader;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\State;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Helper\Js;

class Info extends Fieldset
{
    private $cronFactory;

    private $directoryList;

    private $resourceConn;

    private $productMeta;

    private $reader;

    protected $_fieldRenderer;

    public function __construct(Context $context,
                                Session $authSession,
                                Js $jsHelper,
                                CollectionFactory $cronFactory,
                                DirectoryList $directoryList,
                                Reader $reader,
                                ResourceConnection $resourceConn,
                                ProductMetadataInterface $productMeta,
                                array $data = []) {
        parent::__construct($context, $authSession, $jsHelper, $data);

        $this->cronFactory = $cronFactory;
        $this->directoryList = $directoryList;
        $this->resourceConn = $resourceConn;
        $this->productMeta = $productMeta;
        $this->reader = $reader;
    }
}
