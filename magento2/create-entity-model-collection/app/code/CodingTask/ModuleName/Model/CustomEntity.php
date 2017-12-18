<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

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