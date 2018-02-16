<?php

namespace CodingTask\ModuleName\Controller\Adminhtml\Entity;

use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\Model\View\Result\Redirect;
use CodingTask\ModuleName\Model\CustomEntityFactory;

/**
 * Class Save
 * @package CodingTask\ModuleName\Controller\Adminhtml\Entity
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var
     */
    private $dataPersistor;

    /**
     * @var CustomEntityFactory
     */
    private $customEntityFactory;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param CustomEntityFactory $customEntityFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        CustomEntityFactory $customEntityFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->customEntityFactory = $customEntityFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');

            $model = $this->customEntityFactory->create()->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Custom Entity no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Custom Entity.'));
                $this->dataPersistor->clear('codingtask_modulename_custom_entity');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the Custom Entity.')
                );
            }

            $this->dataPersistor->set('codingtask_modulename_custom_entity', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}