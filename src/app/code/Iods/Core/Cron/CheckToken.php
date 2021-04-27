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

use Iods\Core\Model\Token;

class CHeckToken {

	private $license;

	public function __construct(License $license) {
		$this->license = $license;
	}

	public function execute() {
		$this->license->creckLicense();
	}
}
