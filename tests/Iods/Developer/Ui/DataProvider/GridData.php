<?php
/**
 * Developer tools and gotchas for Magento 2
 *
 * @package   Iods_Developer
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Sagar\Custom\Ui\DataProvider;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Sagar\Custom\Model\ResourceModel\CustomData\CollectionFactory;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Framework\App\RequestInterface;

class GridData extends AbstractDataProvider
{
    /**
     * @var CollectionFactory
     */
    protected $factory;
    /**
     * @var AbstractCollection
     */
    protected $collection;
    /**
     * @var LocatorInterface
     */
    protected $locator;
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @param string $name
     * @param string $locator
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param string $factory
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        CollectionFactory $factory,
        $requestFieldName,
        LocatorInterface $locator,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->factory = $factory;
        $this->collection = $this->factory->create();
        $this->locator = $locator;
        $this->request = $request;
    }

    public function getData()
    {
        $this->getCollection();

        $arrItems = [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => [],
        ];

        foreach ($this->getCollection() as $item) {
            $arrItems['items'][] = $item->toArray([]);
        }

        return $arrItems;
    }
}
