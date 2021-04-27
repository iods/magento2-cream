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

namespace Dholi\Widgets\Setup;

use Dholi\PayU\Api\Data\PaymentMethodInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface {

	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
		$setup->startSetup();

		$tableName = 'dholi_widgets_slider';
		if (!$setup->tableExists($tableName)) {
			$table = $setup->getConnection()->newTable($setup->getTable($tableName))->addColumn(
				'slider_id',
				Table::TYPE_INTEGER,
				10,
				['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
				'Entity ID'
			)->addColumn(
				'store_id',
				Table::TYPE_SMALLINT,
				null,
				['nullable' => false, 'default' => '0'],
				'Store id'
			)->addColumn(
				'title',
				Table::TYPE_TEXT,
				255,
				['nullable' => false, 'default' => ''],
				'Slider title'
			)->addColumn(
				'status',
				Table::TYPE_SMALLINT,
				null,
				['nullable' => false, 'default' => '1'],
				'Slider status'
			)->addColumn(
				'description',
				Table::TYPE_TEXT,
				null,
				['nullable' => true],
				'Slider description'
			);

			$setup->getConnection()->createTable($table);
		}

		$tableName = 'dholi_widgets_slider_item';
		if (!$setup->tableExists($tableName)) {
			$table = $setup->getConnection()->newTable($setup->getTable($tableName))->addColumn(
				'item_id',
				Table::TYPE_INTEGER,
				10,
				['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
				'Entity ID'
			)->addColumn(
				'slider_id',
				Table::TYPE_SMALLINT,
				null,
				['nullable' => false, 'default' => '0'],
				'Slider id'
			)->addColumn(
				'store_id',
				Table::TYPE_SMALLINT,
				null,
				['nullable' => false, 'default' => '0'],
				'Store id'
			)->addColumn(
				'title',
				Table::TYPE_TEXT,
				255,
				['nullable' => true],
				'Slider title'
			)->addColumn(
				'url',
				Table::TYPE_TEXT,
				255,
				['nullable' => true],
				'Url'
			)->addColumn(
				'target_url',
				Table::TYPE_TEXT,
				25,
				['nullable' => true],
				'Target url'
			)->addColumn(
				'type',
				Table::TYPE_SMALLINT,
				null,
				['nullable' => false, 'default' => '0'],
				'Type'
			)->addColumn(
				'image',
				Table::TYPE_TEXT,
				255,
				['nullable' => true],
				'Image'
			)->addColumn(
				'hotspot',
				Table::TYPE_TEXT,
				255,
				['nullable' => true],
				'Hotspot'
			)->addColumn(
				'status',
				Table::TYPE_SMALLINT,
				null,
				['nullable' => false, 'default' => '1'],
				'Slider status'
			)->addColumn(
				'description',
				Table::TYPE_TEXT,
				null,
				['nullable' => true],
				'Slider description'
			)->addColumn(
				'order',
				Table::TYPE_SMALLINT,
				null,
				['nullable' => false, 'default' => '0'],
				'Order'
			);

			$setup->getConnection()->createTable($table);
		}

		$setup->endSetup();
	}
}
