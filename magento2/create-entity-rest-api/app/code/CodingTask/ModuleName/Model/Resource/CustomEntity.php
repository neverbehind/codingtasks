<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

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