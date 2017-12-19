<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

namespace CodingTask\ModuleName\Model;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\TemporaryState\CouldNotSaveException as TemporaryCouldNotSaveException;
use CodingTask\ModuleName\Api\Data\CustomEntityInterface;
use CodingTask\ModuleName\Api\Data\CustomEntitySearchResultsInterfaceFactory;
use CodingTask\ModuleName\Api\CustomEntityRepositoryInterface;

/**
 * Class CustomEntityRepository
 * @package CodingTask\ModuleName\Model
 */
class CustomEntityRepository implements CustomEntityRepositoryInterface
{
    /**
     * @var \CodingTask\ModuleName\Model\Resource\CustomEntity
     */
    private $resourceModel;
    /**
     * @var \CodingTask\ModuleName\Model\CustomEntityFactory
     */
    private $modelFactory;
    /**
     * @var \CodingTask\ModuleName\Model\Resource\CustomEntity\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var \CodingTask\ModuleName\Api\Data\CustomEntitySearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * CustomEntityRepository constructor.
     *
     * @param \CodingTask\ModuleName\Model\Resource\CustomEntity                        $resourceModel
     * @param \CodingTask\ModuleName\Model\CustomEntityFactory                          $modelFactory
     * @param \CodingTask\ModuleName\Model\Resource\CustomEntity\CollectionFactory      $collectionFactory
     * @param \CodingTask\ModuleName\Api\Data\CustomEntitySearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        Resource\CustomEntity $resourceModel,
        CustomEntityFactory $modelFactory,
        Resource\CustomEntity\CollectionFactory $collectionFactory,
        CustomEntitySearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resourceModel        = $resourceModel;
        $this->modelFactory         = $modelFactory;
        $this->collectionFactory    = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function save(CustomEntityInterface $entity)
    {
        try {
            $this->resourceModel->save($entity);
        } catch (\Magento\Framework\DB\Adapter\DeadlockException $exception) {
            $msg = __('Database deadlock found when trying to get lock');
            throw new TemporaryCouldNotSaveException($msg, $exception, $exception->getCode());
        } catch (\Magento\Framework\DB\Adapter\LockWaitException $exception) {
            $msg = __('Database lock wait timeout exceeded');
            throw new TemporaryCouldNotSaveException($msg, $exception, $exception->getCode());
        } catch (\Magento\Framework\Exception\ValidatorException $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($e->getMessage()));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Unable to save entity'), $e
            );
        }

        return $this->get($entity->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        /** @var CustomEntity $model */
        $model = $this->modelFactory->create();
        $this->resourceModel->load($model, (int)$id, $this->resourceModel->getIdFieldName());

        if (!$model->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Requested entity doesn\'t exist')
            );
        }

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Resource\CustomEntity\Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->setSearchCriteriaToCollection($searchCriteria, $collection);

        /** @var \CodingTask\ModuleName\Api\Data\CustomEntitySearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $items = [];
        /** @var CustomEntity $model */
        foreach ($collection as $model) {
            $items[] = $model->getData();
        }
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param                                                $collection
     *
     * @return void
     */
    protected function setSearchCriteriaToCollection(
        SearchCriteriaInterface $searchCriteria,
        $collection
    ) {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder($sortOrder->getField(), ($sortOrder->getDirection()
                    == SortOrder::SORT_ASC) ? SortOrder::SORT_ASC : SortOrder::SORT_DESC);
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(CustomEntityInterface $entity)
    {
        try {
            $this->resourceModel->delete($entity);
        } catch (\Magento\Framework\Exception\ValidatorException $e) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(
                __('Unable to remove entity %1', $entity->getId())
            );
        }
    }
}