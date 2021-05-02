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

class Columns extends \Magento\Ui\Component\Listing\Columns
{
    const DEFAULT_COLUMNS_MAX_ORDER = 100;

    /**
     * @var \MageModule\Core\Ui\Component\Listing\Attribute\RepositoryInterface
     */
    private $attributeRepository;

    /**
     * @var \MageModule\Core\Ui\Component\Listing\ColumnFactory
     */
    private $columnFactory;

    /**
     * @var array
     */
    protected $filterMap = [
        'default'     => 'text',
        'select'      => 'select',
        'boolean'     => 'select',
        'multiselect' => 'select',
        'date'        => 'dateRange',
        'checkbox'    => 'select'
    ];

    /**
     * Columns constructor.
     *
     * @param \MageModule\Core\Ui\Component\Listing\Attribute\RepositoryInterface $attributeRepository
     * @param \MageModule\Core\Ui\Component\Listing\ColumnFactory                 $columnFactory
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface        $context
     * @param array                                                               $components
     * @param array                                                               $data
     */
    public function __construct(
        \MageModule\Core\Ui\Component\Listing\Attribute\RepositoryInterface $attributeRepository,
        \MageModule\Core\Ui\Component\Listing\ColumnFactory $columnFactory,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        $components = [],
        array $data = []
    ) {
        parent::__construct(
            $context,
            $components,
            $data
        );

        $this->attributeRepository = $attributeRepository;
        $this->columnFactory       = $columnFactory;
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function prepare()
    {
        $columnSortOrder = self::DEFAULT_COLUMNS_MAX_ORDER;
        $attributes      = $this->attributeRepository->getList();

        /** @var \MageModule\Core\Api\Data\AttributeInterface $attribute */
        foreach ($attributes->getItems() as $attribute) {
            $config = [];
            if (!isset($this->components[$attribute->getAttributeCode()])) {
                $config['sortOrder'] = ++$columnSortOrder;
                if ($attribute->getIsFilterableInGrid()) {
                    $config['filter'] = $this->getFilterType($attribute->getFrontendInput());
                }
                $column = $this->columnFactory->create($attribute, $this->getContext(), $config);
                $column->prepare();
                $this->addComponent($attribute->getAttributeCode(), $column);
            }
        }
        parent::prepare();
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
        return isset($this->filterMap[$frontendInput]) ?
            $this->filterMap[$frontendInput] :
            $this->filterMap['default'];
    }
}
