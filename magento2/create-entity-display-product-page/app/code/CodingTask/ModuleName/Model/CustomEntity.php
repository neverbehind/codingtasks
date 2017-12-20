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