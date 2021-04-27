<?php
/**
* 
* Widgets para Magento 2
* 
* @category     Dholi
* @package      Modulo Widgets
* @copyright    Copyright (c) 2021 dholi (https://www.dholi.dev)
* @version      1.0.0
* @license      https://www.dholi.dev/license/
*
*/
declare(strict_types=1);

namespace Dholi\Widgets\Model\ResourceModel\Slider\Item\Grid;

class StatusesArray implements \Magento\Framework\Option\ArrayInterface {
	const ENABLED = 1;
	const DISABLED = 2;

	public function toOptionArray() {
		return [self::ENABLED => __('Enabled'), self::DISABLED => __('Disabled')];
	}
}
