<?php

namespace CodingTask\ModuleName\Model\Resource\CustomEntity\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use CodingTask\ModuleName\Model\Resource\CustomEntity;
use Psr\Log\LoggerInterface as Logger;

/**
 * Class Collection
 * @package CodingTask\ModuleName\Model\Resource\CustomEntity\Grid
 */
class Collection extends SearchResult
{
    /**
     * Collection constructor.
     *
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface    $entityFactory
     * @param \Psr\Log\LoggerInterface                                     $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface                    $eventManager
     * @param string                                                       $mainTable
     * @param string                                                       $resourceModel
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable = 'custom_entity',
        $resourceModel = CustomEntity::class
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    /**
     * @return $this
     */
    protected function _beforeLoad()
    {
        // Business/Data Relation Logic goes here
        // e.g. $this->join(['ot' => 'other_table'], 'main_table.foreign_id=ot.entity_id', 'field');

        return parent::_beforeLoad();
    }

}