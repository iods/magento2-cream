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

class CustomerCollection extends \Magento\Framework\App\Helper\AbstractHelper
{

  protected $_collection;

  public function __construct(
    \Magento\Framework\App\Helper\Context $context
  ) {
    parent::__construct($context);
  }

  public function addFieldsToSelect($headers) {
    foreach($headers as $header) {
      $this->_collection->addAttributeToSelect($header['name']);
    }

    return $this->_collection;
  }

  public function collectData($headers) {
    if(!$this->_collection->getSize()) {
      return [];
    }

    $output = [];
    foreach($this->_collection as $_obj) {
      $row = [];
      foreach($headers as $header) {
        $value = $_obj->getData($header['name']);
        $row[] = $value;
      }
      $output[] = $row;
    }

    return $output;
  }

  public function setCollection($collection) {
    $this->_collection = $collection;
    return $this;
  }

  public function getCollection() {
    return $this->_collection;
  }
}
