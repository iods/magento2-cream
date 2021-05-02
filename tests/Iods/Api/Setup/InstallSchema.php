<?php

namespace AHT\ModuleHelloWorld\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $installer = $setup;
        $installer->startSetup();

        //Install new database table
        $table = $installer->getConnection()->newTable($installer->getTable('aht_helloworld_subscription'))
            ->addColumn(
                'subscription_id',
                \Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Subscription Id'
            )->addColumn(
                'created_at',
                \Magento\Framework\Db\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default' => \Magento\Framework\Db\Ddl\Table::TIMESTAMP_INIT
                ],
                'Created at'
            )->addColumn(
                'updated_at',
                \Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
                null,
                [],
                'Updated at'
            )->addColumn(
                'firstname',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                64,
                [
                    'nullable' => false
                ],
                'First name'
            )->addColumn(
                'lastname',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                64,
                [
                    'nullable' => false
                ],
                'Last name'
            )->addColumn(
                'email',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false,
                ],
                'Email address'
            )->addColumn(
                'status',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false,
                    'default' => 'pending'
                ],
                'Status'
            )->addColumn(
                'message',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                '64k',
                [
                    'unsigned' => true,
                    'nullable' => false,
                ],
                'Subscription notes'
            )->addIndex(
                $installer->getIdxName('aht_helloworld_subscription', ['email']),
                ['email']
            )->setComment('Cron Schedule');

        $installer->getConnection()->createTable($table);

        $testimonial = $installer->getConnection()->newTable($installer->getTable('testimonial'))
            ->addColumn(
                'id',
                \Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Id'
            )->addColumn(
                'tittle',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                100,
                [
                    'nullable' => false
                ],
                'Title'
            )->addColumn(
                'content',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ],
                'Content'
            )->addColumn(
                'rate',
                \Magento\Framework\Db\Ddl\Table::TYPE_SMALLINT,
                5,
                [
                    'nullable' => false
                ],
                'Rate'
            )->addColumn(
                'customer',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                50,
                [
                    'nullable' => false,
                ],
                'Customer'
            )->addColumn(
                'customer_position',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                25,
                [
                    'nullable' => false
                ],
                'Customer Position'
            )->addColumn(
                'active',
                \Magento\Framework\Db\Ddl\Table::TYPE_BOOLEAN,
                1,
                [
                    'nullable' => false,
                    'default' => 0
                ],
                'Active'
            );
        $installer->getConnection()->createTable($testimonial);
        $installer->endSetup();
    }
}
