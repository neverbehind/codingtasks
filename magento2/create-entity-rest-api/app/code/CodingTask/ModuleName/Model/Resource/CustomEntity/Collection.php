<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

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