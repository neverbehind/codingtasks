<?php

namespace CodingTask\ModuleName\Controller\Adminhtml\Entity;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;

/**
 * Class Edit
 * @package CodingTask\ModuleName\Controller\Adminhtml\Entity
 */
class Edit extends \CodingTask\ModuleName\Controller\Adminhtml\Entity
{
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return Edit|Page
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->_objectManager->create('CodingTask\ModuleName\Model\CustomEntity');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Custom Entity no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('codingtask_modulename_custom_entity', $model);

        // 5. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Custom Entity') : __('New Custom Entity'),
            $id ? __('Edit Custom Entity') : __('New Custom Entity')
        );
        $resultPage->getConfig()
            ->getTitle()
            ->prepend(__('Custom Entitys'));
        $resultPage->getConfig()
            ->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Custom Entity'));

        return $resultPage;
    }
}