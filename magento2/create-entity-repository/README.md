# Create entity - Repository

Magento 2 Extension: Create entity - Repository.
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 1,5 hours  
**Task Type:** Modifier
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)
2. Setup install scripts - [Setup install Schema and Data](/magento2/setup-install-schema-data).
3. Database table - [Create Entity - database table](/magento2/create-entity-table).
4. Model and collection - [Create Entity - model and collection](/magento2/create-entity-model-collection).
5. API Data structure - [Create Entity - API Data structure](/magento2/create-entity-api-data-structure).

## Task Objectives
- Add repository for custom entity
 
## Instructions
1. Implement search result interface inside `Api/Data` directory
2. Implement entity Repository interface inside `Api` directory
3. Define preferences for DI (Dependency Injection) in `di.xml` file
4. Implement entity Repository class inside `Model` directory

### Search result interface for entity  
The search result interface (`CustomEntitySearchResultsInterface.php`) resides in the module `Api/Data` directory.  
```php
<?php
 
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
```

### Repository interface
The repository interface (`CustomEntityRepositoryInterface.php`) resides in the module `Api` directory.
```php
<?php
 
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
     * @api
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CodingTask\ModuleName\Api\Data\CustomEntitySearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
```

### Dependency Injection definition file
Add this lines inside existing `di.xml` file inside `etc` directory.
```xml
<preference for="CodingTask\ModuleName\Api\CustomEntityRepositoryInterface" 
            type="CodingTask\ModuleName\Model\CustomEntityRepository"/>
<preference for="CodingTask\ModuleName\Api\Data\CustomEntitySearchResultsInterface" 
            type="Magento\Framework\Api\SearchResults"/>
```

### Repository class file
The repository class (`CustomEntityRepository.php`) resides in the module `Model` directory.  
*Sometimes repositories are also located inside `Model/Resource` directory, but since it's more related with model entities than with resources, we'll use above location.*
```php
<?php
 
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
```