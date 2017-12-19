<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

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