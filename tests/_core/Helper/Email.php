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

use Magento\Framework\App\Area;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;

class Email extends Base
{

    protected $inlineTranslation;

    protected $transportBuilder;

    protected $storeManager;

    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context, $objectManager);
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
    }

    protected function send($sender, $receiver, $templateId, $vars, $store = null, $area = Area::AREA_FRONTEND)
    {
        try {
            $store = !$store ? $this->storeManager->getStore()->getStoreId() : $store;

            $this->inlineTranslation->suspend();
            $this->transportBuilder->setTemplateIdentifier($templateId)->setTemplateOptions(['area' => $area, 'store' => $store])->setTemplateVars($vars)->setFrom($sender)->addTo($receiver);
            $transport = $this->transportBuilder->getTransport();
            $transport->sendMessage();

            $this->inlineTranslation->resume();

            return true;
        } catch (\Exception $e) {
            $this->helperLog->errorLog(__METHOD__, $e->getMessage());
            return false;
        }
    }
}