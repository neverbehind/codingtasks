<?php

namespace CodingTask\ModuleName\Controller\Adminhtml\Entity;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Forward;

/**
 * Class Add
 * @package CodingTask\ModuleName\Controller\Adminhtml\Entity
 */
class Add extends \CodingTask\ModuleName\Controller\Adminhtml\Entity
{
    /**
     * @var ForwardFactory
     */
    private $resultForwardFactory;

    /**
     * Add constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Add action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}