<?php

namespace Maxime\Jobs\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Zend_Db_Exception;

/**
 * Class UpgradeSchema
 * @package Maxime\Jobs\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws Zend_Db_Exception
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Action to do if module version is less than 1.0.0.0
        if (version_compare($context->getVersion(), '1.0.0.0') < 0) {

            /**
             * Create table 'maxime_jobs'
             */

            $tableName = $installer->getTable('maxime_job');
            $tableComment = 'Job management on Magento 2';
            $columns = [
                'entity_id' => [
                    'type' => Table::TYPE_INTEGER,
                    'size' => null,
                    'options' => ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'comment' => 'Job Id',
                ],
                'title' => [
                    'type' => Table::TYPE_TEXT,
                    'size' => 255,
                    'options' => ['nullable' => false, 'default' => ''],
                    'comment' => 'Job Title',
                ],
                'type' => [
                    'type' => Table::TYPE_TEXT,
                    'size' => 255,
                    'options' => ['nullable' => false, 'default' => ''],
                    'comment' => 'Job Type (CDI, CDD...)',
                ],
                'location' => [
                    'type' => Table::TYPE_TEXT,
                    'size' => 255,
                    'options' => ['nullable' => false, 'default' => ''],
                    'comment' => 'Job Location',
                ],
                'date' => [
                    'type' => Table::TYPE_DATE,
                    'size' => null,
                    'options' => ['nullable' => false],
                    'comment' => 'Job date begin',
                ],
                'status' => [
                    'type' => Table::TYPE_BOOLEAN,
                    'size' => null,
                    'options' => ['nullable' => false, 'default' => 0],
                    'comment' => 'Job status',
                ],
                'description' => [
                    'type' => Table::TYPE_TEXT,
                    'size' => 2048,
                    'options' => ['nullable' => false, 'default' => ''],
                    'comment' => 'Job description',
                ],
                'department_id' => [
                    'type' => Table::TYPE_INTEGER,
                    'size' => null,
                    'options' => ['unsigned' => true, 'nullable' => false],
                    'comment' => 'Department linked to the job',
                ],
            ];

            $indexes =  [
                'title',
            ];

            $foreignKeys = [
                'department_id' => [
                    'ref_table' => 'maxime_department',
                    'ref_column' => 'entity_id',
                    'on_delete' => Table::ACTION_CASCADE,
                ]
            ];

            /**
             *  We can use the parameters above to create our table
             */

            // Table creation
            $table = $installer->getConnection()->newTable($tableName);

            // Columns creation
            foreach ($columns as $name => $values) {
                $table->addColumn(
                    $name,
                    $values['type'],
                    $values['size'],
                    $values['options'],
                    $values['comment']
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
        }

        if (version_compare($context->getVersion(), '1.0.0.2') < 0) {

            /**
             * Add full text index to our table department
             */

            $tableName = $installer->getTable('maxime_department');
            $fullTextIntex = ['name']; // Column with fulltext index, you can put multiple fields

            $setup->getConnection()->addIndex(
                $tableName,
                $installer->getIdxName($tableName, $fullTextIntex, AdapterInterface::INDEX_TYPE_FULLTEXT),
                $fullTextIntex,
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );

            /**
             * Add full text index to our table jobs
             */

            $tableName = $installer->getTable('maxime_job');
            $fullTextIntex = ['title', 'type', 'location', 'description']; // Column with fulltext index, you can put multiple fields

            $setup->getConnection()->addIndex(
                $tableName,
                $installer->getIdxName($tableName, $fullTextIntex, AdapterInterface::INDEX_TYPE_FULLTEXT),
                $fullTextIntex,
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }

        $installer->endSetup();
    }
}
