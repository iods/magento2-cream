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

namespace Dholi\Widgets\Ui\Component\Listing\Column;

abstract class AbstractColumn extends \Magento\Ui\Component\Listing\Columns\Column {

	public function prepareDataSource(array $dataSource) {
		if (isset($dataSource['data']['items'])) {
			foreach ($dataSource['data']['items'] as &$item) {
				$this->_prepareItem($item);
			}
		}

		return $dataSource;
	}

	abstract protected function _prepareItem(array & $item);
}
