# Setup install Data and Schema

Magento 2 Extension: Scripts triggered during module installation.
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 30 mins  
**Task Type:** Base
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)

## Task Objectives
- Add PHP class where Database Schema could be defined
- Add PHP class where Data modification could be implemented 
 
## Instructions
1. Create `Setup` Directory inside module
2. Create `InstallSchema` file inside `Setup` directory 
3. Create `InstallData` file inside `Setup` directory 
4. Run `php bin/magento setup:upgrade` from the Magento root directory to trigger the module installation
 
### InstallSchema file
The module `InstallSchema.php` file resides in the module `Setup` directory. This class is instantiated during the installation of the module. After class was instantiated the method `install` is called.
```php
<?php
 
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

        /**
         * @TODO Implement some actions related with Database Schema which should be triggered once,
         *       when your module will be installed.
         */

        $setup->endSetup();
    }
}
```     

### InstallData file
The module `InstallData.php` file resides in the module `Setup` directory. This class is instantiated during the installation of the module right after the executing of `InstallSchema` is finished. After class was instantiated the method `install` is called.
```php
<?php
 
namespace CodingTask\ModuleName\Setup;
 
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
 
/**
 * Class InstallData
 * @package CodingTask\ModuleName\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /**
         * @TODO Implement some actions NOT related with Database Schema which should be triggered once,
         *       when your module will be installed.
         *       It could be for example: Updating products attributes, Creating CMS Page or Static Block,
         *       Filling your custom tables (added in InstallSchema) with data and so on.
         */

        $setup->endSetup();
    }
}
```
