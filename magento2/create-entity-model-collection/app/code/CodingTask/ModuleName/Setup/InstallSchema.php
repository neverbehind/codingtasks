<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

namespace CodingTask\ModuleName\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package CodingTask\ModuleName\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $tableName = $setup->getTable('custom_entity');
        $table = $setup->getConnection()->newTable($tableName);
        $table->addColumn(
            'entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
            [
                'primary' => true,
                'identity' => true,
                'nullable' => false,
                'unsigned' => true
            ]
        )->addColumn(
            'code', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 50
        )->addColumn(
            'name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255,
            [
                'nullable' => false,
                'default' => ''
            ]
        )->addColumn(
            'description', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null
        )->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null,
            [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ]
        )->addColumn('updated_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null,
            [
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
            ]
        )->addIndex($setup->getIdxName($tableName, ['code']), ['code']);

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}