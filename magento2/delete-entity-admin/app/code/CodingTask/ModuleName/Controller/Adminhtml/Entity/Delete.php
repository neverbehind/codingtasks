<?php

namespace CodingTask\ModuleName\Controller\Adminhtml\Entity;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\Model\View\Result\Redirect;
use CodingTask\ModuleName\Model\CustomEntityFactory;

/**
 * Class Delete
 * @package CodingTask\ModuleName\Controller\Adminhtml\Entity
 */
class Delete extends \CodingTask\ModuleName\Controller\Adminhtml\Entity
{
    /**
     * @var CustomEntityFactory
     */
    private $customEntityFactory;

    /**
     * Add constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param CustomEntityFactory $customEntityFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        CustomEntityFactory $customEntityFactory
    ) {
        $this->customEntityFactory = $customEntityFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if ID is valid
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                /**
                 * Init model and delete
                 * @var CustomEntity $model
                 */
                $model = $this->customEntityFactory->create()->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Custom Entity.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Custom Entity to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}