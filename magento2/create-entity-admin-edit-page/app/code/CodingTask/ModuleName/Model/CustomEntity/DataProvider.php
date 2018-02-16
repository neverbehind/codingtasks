<?php

namespace CodingTask\ModuleName\Model\CustomEntity;

use Magento\Ui\DataProvider\AbstractDataProvider;
use CodingTask\ModuleName\Model\Resource\CustomEntity\Collection;
use CodingTask\ModuleName\Model\Resource\CustomEntity\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 * @package CodingTask\ModuleName\Model\CustomEntity
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    private $loadedData;

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('codingtask_modulename_custom_entity');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('codingtask_modulename_custom_entity');
        }

        return $this->loadedData;
    }
}