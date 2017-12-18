<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

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