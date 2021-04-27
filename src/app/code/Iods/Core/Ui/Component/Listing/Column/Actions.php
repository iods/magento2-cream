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
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * @package Common\Base
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_base
 */
class Actions extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param UrlInterface       $urlBuilder
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        UrlInterface $urlBuilder,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        $config = $this->getData('config');
        if (isset($config['fieldAction']['params']['route'])
            && isset($dataSource['data']['items'])
        ) {
            $route = rtrim($config['fieldAction']['params']['route'], '/') . '/';
            foreach ($dataSource['data']['items'] as &$item) {
                $item['actions'] = [
                    'edit'   => [
                        'label' => __('Edit'),
                        'href'  => $this->urlBuilder->getUrl($route . 'edit', ['id' => $item['id']])
                    ],
                    'delete' => [
                        'label'   => __('Delete'),
                        'href'    => $this->urlBuilder->getUrl($route . 'delete', ['id' => $item['id']]),
                        'post'    => true,
                        'confirm' => [
                            'title'   => __('Delete'),
                            'message' => __('Are you sure you want to delete the record (ID: %1)?', $item['id'])
                        ],
                    ]
                ];
            }
        }
        return $dataSource;
    }
}
