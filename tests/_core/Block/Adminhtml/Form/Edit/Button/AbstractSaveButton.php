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

use Magento\Framework\Registry;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\UrlInterface;

abstract class AbstractSaveButton extends AbstractButton
{
    /**
     * @var string|null
     */
    protected $editAclResource;

    /**
     * @var string|null
     */
    protected $createAclResource;

    /**
     * AbstractSaveButton constructor.
     *
     * @param Registry               $registry
     * @param AuthorizationInterface $authorization
     * @param UrlInterface           $urlBuilder
     * @param string                 $registryKey
     * @param string                 $editAclResource
     * @param string                 $createAclResource
     * @param string|null            $label
     * @param string|null            $cssClass
     * @param string|int|null        $sortOrder
     * @param string|null            $route
     */
    public function __construct(
        Registry $registry,
        AuthorizationInterface $authorization,
        UrlInterface $urlBuilder,
        $registryKey,
        $editAclResource,
        $createAclResource,
        $label = null,
        $cssClass = null,
        $sortOrder = null,
        $route = null
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
            $editAclResource
        );

        $this->editAclResource   = $editAclResource;
        $this->createAclResource = $createAclResource;
    }

    /**
     * @return bool
     */
    protected function canShowSaveButton()
    {
        return $this->getDataObjectId() ?
            $this->isAuthorized($this->editAclResource) :
            $this->isAuthorized($this->createAclResource);
    }
}
