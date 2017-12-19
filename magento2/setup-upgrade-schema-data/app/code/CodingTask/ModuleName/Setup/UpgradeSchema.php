<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

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