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

use Magento\Framework\App\Helper\AbstractHelper;

class Indexer extends AbstractHelper
{
    /*
    $indexerIds = array(
        'catalog_category_product',
        'catalog_product_category',
        'catalog_product_price',
        'catalog_product_attribute',
        'cataloginventory_stock',
        'catalogrule_product',
        'catalogsearch_fulltext',
    );
    */

    protected $_indexes = [
      'catalog_product_price',
      'catalogrule_product',
    ];

    protected $_indexesImporter = [
      'catalog_product_price',
      'catalogrule_product',
      'catalog_category_product',
      'catalog_product_attribute',
      'catalog_product_category',
      'cataloginventory_stock',
      'catalogrule_product',
    ];

    protected $_indexFactory;

    public function __construct(
      \Magento\Framework\App\Helper\Context $context,
      \Magento\Indexer\Model\IndexerFactory $indexFactory
    ) {
      parent::__construct($context);
      $this->_indexFactory = $indexFactory;
    }

    public function reindexImporterAll() {
      foreach ($this->_indexesImporter as $indexerId) {
          $indexer = $this->_indexFactory->create();
          $indexer->load($indexerId);
          $indexer->reindexAll();
      }
    }

    public function reindexAll() {

      foreach ($this->_indexes as $indexerId) {
          $indexer = $this->_indexFactory->create();
          $indexer->load($indexerId);
          $indexer->reindexAll();
      }

    }
}
