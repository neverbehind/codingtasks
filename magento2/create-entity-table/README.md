# Create entity - database Table

Magento 2 Extension: Create entity - database table.
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 30 mins  
**Task Type:** Modifier
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)
2. Setup install scripts - [Setup install Schema and Data](/magento2/setup-install-schema-data).

## Task Objectives
- Add new table in database
 
## Instructions
1. Define new database table structure in InstallSchema file
2. Run `php bin/magento setup:upgrade` from the Magento root directory to trigger the module installation
3. Verify if table exists

### Defining new database table in InstallSchema file
Open `InstallSchema.php` file (created before). Add Database table definition to `install` method:
```php
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
``` 

Created database table:
```sql
mysql> DESC custom_entity;
+-------------+------------------+------+-----+---------------------+-------------------------------+
| Field       | Type             | Null | Key | Default             | Extra                         |
+-------------+------------------+------+-----+---------------------+-------------------------------+
| entity_id   | int(10) unsigned | NO   | PRI | NULL                | auto_increment                |
| code        | varchar(50)      | YES  | MUL | NULL                |                               |
| name        | varchar(255)     | NO   |     |                     |                               |
| description | text             | YES  |     | NULL                |                               |
| created_at  | timestamp        | NO   |     | current_timestamp() |                               |
| updated_at  | timestamp        | NO   |     | current_timestamp() | on update current_timestamp() |
+-------------+------------------+------+-----+---------------------+-------------------------------+

```

## Research and Useful Links Section
[Magento Tutorial](http://devdocs.magento.com/videos/fundamentals/add-a-new-table-to-database/)
