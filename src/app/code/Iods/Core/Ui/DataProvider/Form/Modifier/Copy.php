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

namespace Iods\Core\Ui\DataProvider\Form\Modifier;
/**
 * Applies javascript to allow copying of value from one field into another field on keyup
 *
 * Class Copy
 *
 * @package MageModule\Core\Ui\DataProvider\Form\Modifier
 */
class Copy implements \Magento\Ui\DataProvider\Modifier\ModifierInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Magento\Framework\Stdlib\ArrayManager
     */
    private $arrayManager;

    /**
     * @var array
     */
    private $links;

    /**
     * @var string
     */
    private $registryKey;

    /**
     * @var string
     */
    private $dataScopeKey;

    /**
     * Copy constructor.
     *
     * @param \Magento\Framework\Registry            $registry
     * @param \Magento\Framework\Stdlib\ArrayManager $arrayManager
     * @param array                                  $links
     * @param string                                 $registryKey
     * @param string                                 $dataScopeKey
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Stdlib\ArrayManager $arrayManager,
        array $links,
        $registryKey,
        $dataScopeKey = 'data'
    ) {
        $this->registry     = $registry;
        $this->arrayManager = $arrayManager;
        $this->links        = $links;
        $this->registryKey  = $registryKey;
        $this->dataScopeKey = $dataScopeKey;
    }

    /**
     * @param array $meta
     *
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        if ($this->getDataObject()->isObjectNew()) {
            foreach ($this->links as $link) {
                $toPath   = $this->arrayManager->findPath($link['to'], $meta, null, 'children');
                $fromPath = $this->arrayManager->findPath($link['from'], $meta, null, 'children');
                if ($fromPath && $toPath) {
                    $config = [
                        'mask'        => '{{' . $link['from'] . '}}',
                        'component'   => 'MageModule_Core/js/components/import-handler',
                        'allowImport' => true
                    ];

                    $meta = $this->arrayManager->merge(
                        $toPath . '/arguments/data/config',
                        $meta,
                        $config
                    );

                    $meta = $this->arrayManager->merge(
                        $fromPath . '/arguments/data/config',
                        $meta,
                        [
                            'valueUpdate' => 'keyup'
                        ]
                    );
                }
            }
        }

        return $meta;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * @return \MageModule\Core\Model\AbstractExtensibleModel
     */
    private function getDataObject()
    {
        return $this->registry->registry($this->registryKey);
    }
}