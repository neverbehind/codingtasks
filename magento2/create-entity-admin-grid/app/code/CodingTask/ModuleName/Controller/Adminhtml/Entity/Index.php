<?php

namespace CodingTask\ModuleName\Controller\Adminhtml\Entity;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var
     */
    protected $_resultPage;

    /**
     * @var \Magento\Backend\Model\Session
     */
    protected $_adminSession;

    /**
     * Index constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->_adminSession = $context->getSession();
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $this->_setPageData();
        return $this->getResultPage();
    }

    /**
     * Check permission via ACL resource
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('CodingTask_ModuleName::admin');
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function getResultPage()
    {
        if (is_null($this->_resultPage)) {
            $this->_resultPage = $this->_resultPageFactory->create();
        }
        return $this->_resultPage;
    }

    /**
     * @return $this
     */
    protected function _setPageData()
    {
        $resultPage = $this->getResultPage();
        $resultPage->getConfig()->getTitle()->prepend((__('Manage Entity')));

        return $this;
    }
}