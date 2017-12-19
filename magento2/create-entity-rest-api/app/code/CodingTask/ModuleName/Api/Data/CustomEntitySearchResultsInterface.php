<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

namespace CodingTask\ModuleName\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface CustomEntitySearchResultsInterface
 * @api
 * @package CodingTask\ModuleName\Api\Data
 */
interface CustomEntitySearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \CodingTask\ModuleName\Api\Data\CustomEntityInterface[]
     */
    public function getItems();

    /**
     * @param \CodingTask\ModuleName\Api\Data\CustomEntityInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}