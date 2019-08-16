<?php

namespace Elogic\Vendors\Setup;

use Elogic\Vendors\Model\Vendor;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        if (!$setup->tableExists(Vendor::ENTITY)) {
            $installer->startSetup();

            /**
             * Create table 'elogic_vendor'
             */
            $tableName = $installer->getTable('elogic_vendor');

            $tableComment = 'Store vendors';
            $columns = [
                'entity_id' => [
                    'type' => Table::TYPE_INTEGER,
                    'size' => null,
                    'options' => [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true,
                    ],
                    'comment' => 'Vendor ID',
                ],
                'name' => [
                    'type' => Table::TYPE_TEXT,
                    'size' => 255,
                    'options' => [
                        'nullable' => false,
                        'default' => '',
                    ],
                    'comment' => 'Vendor NAME',
                ],
                'description' => [
                    'type' => Table::TYPE_TEXT,
                    'size' => 2048,
                    'options' => [
                        'nullable' => false,
                        'default' => '',
                    ],
                    'comment' => 'Vendor DESCRIPTION',
                ],
                'date' => [
                    'type' => Table::TYPE_DATE,
                    'size' => null,
                    'options' => [
                        'nullable' => false
                    ],
                    'comment' => 'Vendor added DATE',
                ],
                'logo' => [
                    'type' => Table::TYPE_TEXT,
                    'size' => 2048,
                    'options' => [
                        'nullable' => false
                    ],
                    'comment' => 'Vendor LOGO',
                ],
            ];

            $indexes = [];
            $foreignKeys = [];

            // Table creation
            $table = $installer->getConnection()->newTable($tableName);

            // Columns creation
            foreach ($columns as $name => $column) {
                $table->addColumn(
                    $name,
                    $column['type'],
                    $column['size'],
                    $column['options'],
                    $column['comment']
                );
            }

            // Indexes creation
            foreach ($indexes as $index) {
                $table->addIndex(
                    $installer->getIdxName($tableName, [$index]),
                    [$index]
                );
            }

            // Foreign keys creation
            foreach ($foreignKeys as $column => $foreignKey) {
                $table->addForeignKey(
                    $installer->getFkName($tableName, $column, $foreignKey['ref_table'], $foreignKey['ref_column']),
                    $column,
                    $foreignKey['ref_table'],
                    $foreignKey['ref_column'],
                    $foreignKey['on_delete']
                );
            }

            // Table comment
            $table->setComment($tableComment);

            // Execute SQL to create the table
            $installer->getConnection()->createTable($table);

            // End Setup
            $installer->endSetup();
        }
    }
}
