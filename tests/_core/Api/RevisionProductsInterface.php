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

namespace Iods\Core\Api;

interface RevisionProductsInterface {

  /**
   * Get all revisions
   * @return string
   */
  public function allrevisions();

  /**
   * Get all revisions
   * @return string
   */
  public function revision();


  /**
   * Get revision details
   * @return string
   */
  public function loadrevision();

}
