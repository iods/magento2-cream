<?php
/**
* 
* Payment Core para Magento 2
* 
* @category     Dholi
* @package      Modulo Payment Core
* @copyright    Copyright (c) 2021 dholi (https://www.dholi.dev)
* @version      1.1.1
* @license      https://opensource.org/licenses/OSL-3.0
* @license      https://opensource.org/licenses/AFL-3.0
*
*/

declare(strict_types=1);

namespace Dholi\Payment\Setup;

use Dholi\Payment\Api\Data\OrderPaymentInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface {

	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
		$table = $setup->getTable('sales_order_payment');
		$connection = $setup->getConnection();

		if ($connection->tableColumnExists($table, OrderPaymentInterface::CANCEL_AT) === false) {
			$connection->addColumn($table,
				OrderPaymentInterface::CANCEL_AT,
				[
					'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
					'comment' => 'Cancel At'
				]
			);
		}

		$setup->startSetup();
	}
}
