# Create entity - model and collection

Magento 2 Extension: Create entity - model and collection.
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 30 mins  
**Task Type:** Modifier
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)
2. Setup install scripts - [Setup install Schema and Data](/magento2/setup-install-schema-data).
3. Database table - [Create Entity - database table](/magento2/create-entity-table).

## Task Objectives
- Add entity model for existing database table 
 
## Instructions
1. Create `Model/Resource/CustomEntity` directories structure
2. Implement Resource model class inside `Model/Resource` directory
3. Implement Model class inside `Model` directory
4. Implement Resource Collection model class inside `Model/Resource/Collection` directory

### Resource model class file
The entity resource model class (`CustomEntity.php`) resides in the module `Model/Resource` directory.
```php
<?php
 
namespace CodingTask\ModuleName\Model\Resource;
 
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
 
/**
 * Class CustomEntity
 * @package CodingTask\ModuleName\Model\Resource
 */
class CustomEntity extends AbstractDb
{
    const ID_FIELD = 'entity_id';
    const TABLE    = 'custom_entity';
 
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(self::TABLE, self::ID_FIELD);
    }
}
``` 

### Model class file
The entity model class (`CustomEntity.php`) resides in the module `Model` directory.
```php
<?php
 
namespace CodingTask\ModuleName\Model;
 
use Magento\Framework\Model\AbstractModel;
 
/**
 * Class CustomEntity
 * @package CodingTask\ModuleName\Model
 */
class CustomEntity extends AbstractModel
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(\CodingTask\ModuleName\Model\Resource\CustomEntity::class);
    }
}
```

### Resource Collection model class file
The entity resource collection model class (`Collection.php`) resides in the module `Model/Resource/CustomEntity` directory.
```php
<?php
 
namespace CodingTask\ModuleName\Model\Resource\CustomEntity;
 
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
 
/**
 * Class Collection
 * @package CodingTask\ModuleName\Model\Resource\CustomEntity
 */
class Collection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(
            \CodingTask\ModuleName\Model\CustomEntity::class, 
            \CodingTask\ModuleName\Model\Resource\CustomEntity::class
        );
    }
}
```
