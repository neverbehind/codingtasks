<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

namespace CodingTask\ModuleName\Api;

/**
 * Interface CustomEntityRepositoryInterface
 * @api
 * @package CodingTask\ModuleName\Api
 */
interface CustomEntityRepositoryInterface
{
    /**
     * @api
     * @param \CodingTask\ModuleName\Api\Data\CustomEntityInterface $customEntity
     * @return \CodingTask\ModuleName\Api\Data\CustomEntityInterface
     */
    public function save(\CodingTask\ModuleName\Api\Data\CustomEntityInterface $customEntity);

    /**
     * @api
     * @param $id
     * @return \CodingTask\ModuleName\Api\Data\CustomEntityInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($id);

    /**
     * @param \CodingTask\ModuleName\Api\Data\CustomEntityInterface $customEntity
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\CodingTask\ModuleName\Api\Data\CustomEntityInterface $customEntity);

    /**
     * @param int $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function deleteById($id);

    /**
     * @api
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CodingTask\ModuleName\Api\Data\CustomEntitySearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}