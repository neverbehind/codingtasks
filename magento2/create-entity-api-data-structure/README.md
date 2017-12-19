# Create entity - API Data structure

Magento 2 Extension: Create entity - API Data structure.
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 1 hour  
**Task Type:** Modifier
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)
2. Setup install scripts - [Setup install Schema and Data](/magento2/setup-install-schema-data).
3. Database table - [Create Entity - database table](/magento2/create-entity-table).
4. Model and collection - [Create Entity - model and collection](/magento2/create-entity-model-collection).

## Task Objectives
- Add abstract layer for managing entities
 
## Instructions
1. Create `Api/Data` directories structure
2. Implement API data entity interface inside `Api/Data` directory
3. Update entity model implementation
4. Define preferences for DI (Dependency Injection) in `di.xml` file

### API Data structure for entity model 
The entity API Data interface (`CustomEntityInterface.php`) resides in the module `Api/Data` directory.
```php
<?php
namespace CodingTask\ModuleName\Api\Data;
 
/**
 * Interface CustomEntityInterface
 * @api
 * @package CodingTask\ModuleName\Api\Data
 */
interface CustomEntityInterface
{
    /**#@+
     * Constants defined for keys of  data array
     */
    const CODE = 'code';
    const NAME = 'name';
    const DESCRIPTION = 'description';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**#@-*/
 
    /**
     * @return int|null
     */
    public function getId();
 
    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);
 
    /**
     * @return string|null
     */
    public function getCode();
 
    /**
     * @param $code
     * @return $this
     */
    public function setCode($code);
 
    /**
     * @return string|null
     */
    public function getName();
 
    /**
     * @param $name
     * @return $this
     */
    public function setName($name);
 
    /**
     * @return string|null
     */
    public function getDescription();
 
    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description);
 
    /**
     * @return string|null
     */
    public function getCreatedAt();
 
    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);
 
    /**
     * @return string|null
     */
    public function getUpdatedAt();
 
    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
``` 

### Updated Model class file
The existing entity model should now implement `CustomerEntityInterface` and all its methods:
```php
<?php
 
namespace CodingTask\ModuleName\Model;
 
use Magento\Framework\Model\AbstractModel;
 
/**
 * Class CustomEntity
 * @package CodingTask\ModuleName\Model
 */
class CustomEntity extends AbstractModel implements \CodingTask\ModuleName\Api\Data\CustomEntityInterface
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(\CodingTask\ModuleName\Model\Resource\CustomEntity::class);
    }
 
    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->_getData(self::CODE);
    }
 
    /**
     * {@inheritdoc}
     */
    public function setCode($code)
    {
        return $this->setData(self::CODE, $code);
    }
 
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }
 
    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }
 
    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->_getData(self::DESCRIPTION);
    }
 
    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }
 
    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->_getData(self::CREATED_AT);
    }
 
    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
 
    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->_getData(self::UPDATED_AT);
    }
 
    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
```

### Dependency Injection definition file
Definition for DI should be located in `di.xml`. This file resides in `etc` directory.   
Be aware that namespaces inside this file don't contain leading backslash sign.  
Adding preference record to the DI gives certainty that each time Magento will try to instantiate `CustomEntityInterface`, `CustomEntity` will be returned.
```xml
<?xml version="1.0"?>
 
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <preference for="CodingTask\ModuleName\Api\Data\CustomEntityInterface" 
                type="CodingTask\ModuleName\Model\CustomEntity"/>
</config>
```
