<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

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