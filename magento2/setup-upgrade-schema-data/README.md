# Setup upgrade Data and Schema

Magento 2 Extension: Scripts triggered during module upgrade.
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 30 mins  
**Task Type:** Base
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)
2. Already installed module.

## Task Objectives
- Add PHP class where Database Schema could be modified
- Add PHP class where Data modification could be implemented 
 
## Instructions
1. Modify module definition file
2. Create `Setup` Directory inside module
3. Create `UpgradeSchema` file inside `Setup` directory 
4. Create `UpgradeData` file inside `Setup` directory 
5. Run `php bin/magento setup:upgrade` from the Magento root directory to trigger the module upgrade

### InstallSchema file
The module `UpgradeSchema.php` file resides in the module `Setup` directory. This class is instantiated during the upgrading version of the module. After class was instantiated the method `upgrade` is called.
```php
<?php
 
namespace CodingTask\ModuleName\Setup;
 
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
 
/**
 * Class UpgradeSchema
 * @package CodingTask\ModuleName\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            /**
             * @TODO Implement some actions related with Database Schema that will be triggered
             *       during bin/magento setup:upgrade, when the module version in Database will
             *       be lower than version above (in this case 1.1.0).
             *       Magento will compare version number above with version number stored in
             *       the column data_version of setup_module table.
             */
        }
        $setup->endSetup();
    }
}
```     

### InstallData file
The module `UpgradeData.php` file resides in the module `Setup` directory. This class is instantiated during the upgrading version of the module right after the executing of `UpgradeSchema` is finished. After class was instantiated the method `upgrade` is called.
```php
<?php
 
namespace CodingTask\ModuleName\Setup;
 
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
 
/**
 * Class UpgradeData
 * @package CodingTask\ModuleName\Setup
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            /**
             * @TODO Implement some actions related with data management, that will be triggered
             *       during bin/magento setup:upgrade, when the module version in Database will
             *       be lower than version above (in this case 1.1.0).
             *       Magento will compare version number below with version number stored in
             *       the column data_version of setup_module table.
             */
        }
        $setup->endSetup();
    }
}
```

## Additional information

- Upgrade classes are be able to execute the same kind of tasks as Install classes. Upgrade classes are used mostly to modify existing db tables and data once module was installed before. 