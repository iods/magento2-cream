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

use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;

/**
 * Class ColumnFactory
 *
 * @package MageModule\Core\Ui\Component\Listing
 */
class ColumnFactory
{
    /**
     * @var \Magento\Framework\View\Element\UiComponentFactory
     */
    protected $componentFactory;

    /**
     * @var array
     */
    protected $jsComponentMap = [
        'text'        => 'Magento_Ui/js/grid/columns/column',
        'select'      => 'Magento_Ui/js/grid/columns/select',
        'multiselect' => 'Magento_Ui/js/grid/columns/select',
        'checkbox'    => 'Magento_Ui/js/grid/columns/select',
        'date'        => 'Magento_Ui/js/grid/columns/date',
    ];

    /**
     * @var array
     */
    protected $dataTypeMap = [
        'default'     => 'text',
        'text'        => 'text',
        'boolean'     => 'select',
        'select'      => 'select',
        'checkbox'    => 'select',
        'multiselect' => 'multiselect',
        'date'        => 'date',
    ];

    /**
     * @param \Magento\Framework\View\Element\UiComponentFactory $componentFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponentFactory $componentFactory
    ) {
        $this->componentFactory = $componentFactory;
    }

    /**
     * @param \MageModule\Core\Api\Data\AttributeInterface                 $attribute
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param array                                                        $config
     *
     * @return \Magento\Framework\View\Element\UiComponentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function create($attribute, $context, array $config = [])
    {
        $columnName = $attribute->getAttributeCode();
        $config     = array_merge(
            [
                'label'     => __($attribute->getDefaultFrontendLabel()),
                'dataType'  => $this->getDataType($attribute),
                'add_field' => true,
                'visible'   => $attribute->getIsVisibleInGrid(),
                'filter'    => ($attribute->getIsFilterableInGrid())
                    ? $this->getFilterType($attribute->getFrontendInput())
                    : null,
            ],
            $config
        );

        if ($attribute instanceof AbstractAttribute && $attribute->usesSource()) {
            $config['options'] = $attribute->getSource()->getAllOptions();
        }

        $config['component'] = $this->getJsComponent($config['dataType']);

        $arguments = [
            'data'    => [
                'config' => $config,
            ],
            'context' => $context,
        ];

        return $this->componentFactory->create($columnName, 'column', $arguments);
    }

    /**
     * @param string $dataType
     *
     * @return string
     */
    protected function getJsComponent($dataType)
    {
        return $this->jsComponentMap[$dataType];
    }

    /**
     * @param \MageModule\Core\Api\Data\AttributeInterface $attribute
     *
     * @return string
     */
    protected function getDataType($attribute)
    {
        return isset($this->dataTypeMap[$attribute->getFrontendInput()])
            ? $this->dataTypeMap[$attribute->getFrontendInput()]
            : $this->dataTypeMap['default'];
    }

    /**
     * Retrieve filter type by $frontendInput
     *
     * @param string $frontendInput
     *
     * @return string
     */
    protected function getFilterType($frontendInput)
    {
        $filtersMap = ['date' => 'dateRange'];
        $result     = array_replace_recursive($this->dataTypeMap, $filtersMap);
        return isset($result[$frontendInput]) ? $result[$frontendInput] : $result['default'];
    }
}
