# Custom Entity - Admin Delete

Magento 2 Custom Entity Admin Delete.
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 1 hours
**Task Type:** Base
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)
2. Setup install scripts - [Setup install Schema and Data](/magento2/setup-install-schema-data).
3. Database table - [Create Entity - database table](/magento2/create-entity-table).
4. Model and collection - [Create Entity - model and collection](/magento2/create-entity-model-collection).
5. API Data structure - [Create Entity - API Data structure](/magento2/create-entity-api-data-structure).
6. Repository - [Create Entity - Repository](/magento2/create-entity-repository).
7. Admin grid - [Create Entity - Admin Grid](/magento2/create-entity-admin-grid).
8. Admin add/edit entity form - [Create Entity - Admin Add/Edit Form](/magento2/create-entity-admin-edit-page).

## Task Objectives
- Delete custom entity add mass delete action in admin
 
## Instructions
1. Update UI Component Datasource
1. Update Grid UI Component Definition File
1. Update Add/Edit Form UI Component Definition File
1. Create Admin Controller Actions
1. Create Block Classes

### UI Component Datasource
The UI Component Listing Column DataSource `CustomEntityActions.php` is placed in the `UI/Component/Listing/Column` directory.
File updated with delete action.
```php
<?php

namespace CodingTask\ModuleName\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;

/**
 * Class CustomEntityActions
 * @package CodingTask\ModuleName\Ui\Component\Listing\Column
 */
class CustomEntityActions extends Column
{
    // Other php content

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $item[$this->getData('name')] = [
                        // Other php content
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'entity_id' => $item['entity_id']
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "${ $.$data.name }"'),
                                'message' => __('Are you sure you wan\'t to delete a "${ $.$data.name }" record?')
                            ]
                        ]
                        // Other php content
                    ];
                }
            }
        }

        return $dataSource;
    }
    // Other php content
}
```

### Grid UI Component Definition File
The Admin Grid UI Component `custom_entity_listing.xml` is placed in the `view/adminhtml/ui_component` directory.
File updated with ids selector column and mass action dropdown. 
```xml
<?xml version="1.0" encoding="UTF-8"?>
<listing xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Ui:etc/ui_configuration.xsd">

    <!-- Other xml content -->
    
    <listingToolbar name="listing_top">
        <argument name="data" xsi:type="array">
            <item name="config" xsi:type="array">
                <item name="sticky" xsi:type="boolean">true</item>
            </item>
        </argument>
        <bookmark name="bookmarks"/>
        <columnsControls name="columns_controls"/>
        <filterSearch name="fulltext"/>
        <filters name="listing_filters"/>
        <paging name="listing_paging"/>
        <massaction name="listing_massaction">
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="component" xsi:type="string">Magento_Ui/js/grid/tree-massactions</item>
                </item>
            </argument>
            <action name="delete">
                <argument name="data" xsi:type="array">
                    <item name="config" xsi:type="array">
                        <item name="type" xsi:type="string">delete</item>
                        <item name="label" xsi:type="string" translate="true">Delete</item>
                        <item name="url" xsi:type="url" path="custom/entity/massDelete"/>
                        <item name="confirm" xsi:type="array">
                            <item name="title" xsi:type="string" translate="true">Delete Custom Entity</item>
                            <item name="message" xsi:type="string" translate="true">Are you sure you wan't to delete selected items?</item>
                        </item>
                    </item>
                </argument>
            </action>
        </massaction>
    </listingToolbar>
    
    <!-- Other xml content -->
    
    <columns name="custom_entity_columns">
    
        <!-- Other xml content -->
    
        <selectionsColumn name="ids">
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="resizeEnabled" xsi:type="boolean">false</item>
                    <item name="resizeDefaultWidth" xsi:type="string">55</item>
                    <item name="indexField" xsi:type="string">entity_id</item>
                    <item name="sortOrder" xsi:type="number">10</item>
                </item>
            </argument>
        </selectionsColumn>
        
        <!-- Other xml content -->
        
    </columns>
</listing>
```

### Add/Edit Form UI Component Definition File
The Admin Entity Add/Edit Form UI Component `custom_entity_form.xml` is placed in the `view/adminhtml/ui_component` directory.
File updated with delete button. 
```xml
<?xml version="1.0" ?>
<form xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Ui:etc/ui_configuration.xsd">
    <!-- Other xml content -->
    <argument name="data" xsi:type="array">
        <!-- Other di.xml content -->
        <item name="buttons" xsi:type="array">
            <!-- Other xml content -->
            <item name="delete" xsi:type="string">CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit\DeleteButton</item>
            <!-- Other di.xml content -->
        </item>
        <!-- Other xml content -->
    </argument>
    <!-- Other xml content -->
</form>
```

### Admin Controller Actions
The Admin Controller Action `Delete.php` is placed in the `Controller/Adminhtml/Entity` directory
```php
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
```

The Admin Controller Action `MassDelete.php` is placed in the `Controller/Adminhtml/Entity` directory
```php
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
```

### Add/Edit Form Block Classes
The Admin Add/Edit Form Block `DeleteButton.php` is placed in the `Block/Adminhtml/CustomEntity/Edit` directory 
```php
<?php

namespace CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 * @package CodingTask\ModuleName\Block\Adminhtml\Custom\Entity\Edit
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getModelId()) {
            $data = [
                'label' => __('Delete Custom Entity'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\''
                    . __('Are you sure you want to do this?')
                    . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * Get URL for delete button
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['entity_id' => $this->getModelId()]);
    }
}
```
## Research and Useful Links Section
[Magento Documentation: UI Bookmark](http://devdocs.magento.com/guides/v2.0/ui-components/ui-secondary-bookmark.html)<br/>
[Stackexchange: Flushing UI Bookmarks](https://magento.stackexchange.com/questions/113764/magento-2-custom-grid-column-sort-order#answer-134974)
