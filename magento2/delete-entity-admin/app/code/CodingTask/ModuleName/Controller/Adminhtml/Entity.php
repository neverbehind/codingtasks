<?php

namespace CodingTask\ModuleName\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Backend\Model\View\Result\Page;

/**
 * Class Entity
 * @package CodingTask\ModuleName\Controller\Adminhtml
 */
abstract class Entity extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    const ADMIN_RESOURCE = 'CodingTask_ModuleName::top_level';

    /**
     * Entity constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry
    ) {
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    public function initPage(Page $resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('CodingTask'), __('CodingTask'))
            ->addBreadcrumb(__('Custom Entity'), __('Custom Entity'));
        return $resultPage;
    }
}