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

namespace Iods\Core\Block\Adminhtml\Form\Edit\Button;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;

class Delete extends AbstractButton
{
    /**
     * @var string
     */
    private $confirmationMessage;

    /**
     * Delete constructor.
     *
     * @param Registry               $registry
     * @param AuthorizationInterface $authorization
     * @param UrlInterface           $urlBuilder
     * @param string|null            $registryKey
     * @param string|null            $label
     * @param string|null            $cssClass
     * @param string|int|null        $sortOrder
     * @param string|null            $route
     * @param string|null            $aclResource
     * @param string                 $confirmationMessage
     */
    public function __construct(
        Registry $registry,
        AuthorizationInterface $authorization,
        UrlInterface $urlBuilder,
        $registryKey = null,
        $label = null,
        $cssClass = null,
        $sortOrder = null,
        $route = null,
        $aclResource = null,
        $confirmationMessage = 'Are you sure you want to delete this item?'
    ) {
        parent::__construct(
            $registry,
            $authorization,
            $urlBuilder,
            $registryKey,
            $label,
            $cssClass,
            $sortOrder,
            $route,
            $aclResource
        );

        $this->confirmationMessage = $confirmationMessage;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getDataObjectId()) {
            $data = [
                'label'      => __($this->label ? $this->label : 'Delete'),
                'class'      => $this->cssClass,
                'on_click'   => 'deleteConfirm(\'' . __($this->confirmationMessage) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => $this->sortOrder,
                'disabled'   => !$this->isAuthorized($this->aclResource)
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl($this->route ? $this->route : '*/*/delete', ['id' => $this->getDataObjectId()]);
    }
}
