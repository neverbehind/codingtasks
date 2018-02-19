<?php

namespace CodingTask\ModuleName\Controller\Adminhtml\Entity;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Catalog\Controller\Adminhtml\Product\Builder;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use CodingTask\ModuleName\Model\Resource\CustomEntity\CollectionFactory;
use Magento\Backend\Model\View\Result\Redirect;

/**
 * Class MassDelete
 * @package CodingTask\ModuleName\Controller\Adminhtml\Entity
 */
class MassDelete extends Action
{
    /**
     * Massactions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param Builder $productBuilder
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Builder $productBuilder,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $productBuilder);
    }

    /**
     * @return Redirect
     */
    public function execute()
    {
        /** @var \CodingTask\ModuleName\Model\Resource\CustomEntity\Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('entity_id', ['in' => $this->getRequest()->getParam('selected')]);
        $itemDeleted = 0;
        foreach ($collection->getItems() as $item) {
            /** @var \CodingTask\ModuleName\Model\CustomEntity $item */
            $item->delete();
            $itemDeleted++;
        }
        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been deleted.', $itemDeleted)
        );

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}
