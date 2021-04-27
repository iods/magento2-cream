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

namespace Iods\Core\Ui\Component;

/**
 * Class AbstractActions
 *
 * @package MageModule\Core\Ui\Component\Listing\Columns
 */
abstract class AbstractActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $authorization;

    /**
     * AbstractActions constructor.
     *
     * @param \Magento\Framework\UrlInterface                              $urlBuilder
     * @param \Magento\Framework\AuthorizationInterface                    $authorization
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory           $uiComponentFactory
     * @param array                                                        $components
     * @param array                                                        $data
     */
    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\AuthorizationInterface $authorization,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );

        $this->urlBuilder    = $urlBuilder;
        $this->authorization = $authorization;
    }

    /**
     * @param string $route
     * @param array $params
     *
     * @return string
     */
    protected function getUrl($route, array $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }

    /**
     * @param string $resource
     *
     * @return bool
     */
    protected function isAuthorized($resource)
    {
        return $this->authorization->isAllowed($resource);
    }
}
