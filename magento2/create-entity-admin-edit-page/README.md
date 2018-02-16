# Custom Entity - Admin Add/Edit Form

Magento 2 Custom Entity Admin Add/Edit Form.
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 3 hours
**Task Type:** Base
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)
2. Setup install scripts - [Setup install Schema and Data](/magento2/setup-install-schema-data).
3. Database table - [Create Entity - database table](/magento2/create-entity-table).
4. Model and collection - [Create Entity - model and collection](/magento2/create-entity-model-collection).
5. API Data structure - [Create Entity - API Data structure](/magento2/create-entity-api-data-structure).
6. Repository - [Create Entity - Repository](/magento2/create-entity-repository).
7. Admin grid - [Create Entity - Admin Grid](/magento2/create-entity-admin-grid).

## Task Objectives
- Add custom entity add and edit form in admin
 
## Instructions
1. Define UI Component DataProvider
1. Update Grid UI Component Definition File
1. Create Add/Edit Form UI Component Definition File
1. Create Layout Directives
1. Create Admin Controller Actions
1. Create Block Classes

### UI Component DataProvider Class
The UI Component `DataProvider.php` is placed in the `Model/CustomEntity` directory
```php
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
```

The UI Component `CustomEntityActions.php` is placed in the `UI/Component/Listing/Column` directory
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
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**@+
     * Urls
     */
    const URL_PATH_DETAILS = 'custom/entity/details';
    const URL_PATH_EDIT = 'custom/entity/edit';
    const URL_PATH_DELETE = 'custom/entity/delete';
    /**@-*/

    /**
     * CustomEntityActions constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

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
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                [
                                    'entity_id' => $item['entity_id']
                                ]
                            ),
                            'label' => __('Edit')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
```

### Grid UI Component Definition File
The Admin Grid UI Component `custom_entity_listing.xml` is placed in the `view/adminhtml/ui_component` directory.
File updated with action column. 
```xml
<?xml version="1.0" encoding="UTF-8"?>
<listing xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Ui:etc/ui_configuration.xsd">

    <argument name="context" xsi:type="configurableObject">
        <argument name="class" xsi:type="string">Magento\Framework\View\Element\UiComponent\Context</argument>
        <argument name="namespace" xsi:type="string">custom_entity_index</argument>
    </argument>

    <argument name="data" xsi:type="array">
        <item name="js_config" xsi:type="array">
            <item name="provider" xsi:type="string">custom_entity_listing.custom_entity_listing_data_source</item>
            <item name="deps" xsi:type="string">custom_entity_listing.custom_entity_listing_data_source</item>
        </item>
        <item name="spinner" xsi:type="string">custom_entity_columns</item>
        <item name="acl" xsi:type="string">CodingTask_ModuleName::admin</item>
        <item name="buttons" xsi:type="array">
            <item name="add" xsi:type="array">
                <item name="name" xsi:type="string">add</item>
                <item name="label" translate="true" xsi:type="string">Add New Custom Entity</item>
                <item name="class" xsi:type="string">primary</item>
                <item name="url" xsi:type="string">*/*/add</item>
            </item>
        </item>
    </argument>

    <dataSource name="custom_entity_listing_data_source">
        <argument name="dataProvider" xsi:type="configurableObject">
            <argument name="class" xsi:type="string">Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider</argument>
            <argument name="name" xsi:type="string">custom_entity_listing_data_source</argument>
            <argument name="primaryFieldName" xsi:type="string">entity_id</argument>
            <argument name="requestFieldName" xsi:type="string">id</argument>
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="component" xsi:type="string">Magento_Ui/js/grid/provider</item>
                    <item name="update_url" xsi:type="url" path="mui/index/render"/>
                    <item name="storageConfig" xsi:type="array">
                        <item name="indexField" xsi:type="string">entity_id</item>
                    </item>
                </item>
            </argument>
        </argument>
    </dataSource>

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
    </listingToolbar>

    <columns name="custom_entity_columns">
        <column name="entity_id">
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="filter" xsi:type="string">textRange</item>
                    <item name="sorting" xsi:type="string">asc</item>
                    <item name="label" xsi:type="string" translate="true">ID</item>
                    <item name="sortOrder" xsi:type="number">20</item>
                </item>
            </argument>
        </column>
        <actionsColumn class="CodingTask\ModuleName\Ui\Component\Listing\Column\CustomEntityActions" name="actions">
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="indexField" xsi:type="string">entity_id</item>
                </item>
            </argument>
        </actionsColumn>
        <column name="code">
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="filter" xsi:type="string">text</item>
                    <item name="label" xsi:type="string" translate="true">Code</item>
                    <item name="sortOrder" xsi:type="number">40</item>
                </item>
            </argument>
        </column>
        <column name="name">
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="filter" xsi:type="string">text</item>
                    <item name="label" xsi:type="string" translate="true">Name</item>
                    <item name="sortOrder" xsi:type="number">60</item>
                </item>
            </argument>
        </column>
    </columns>
</listing>
```

### Add/Edit Form UI Component Definition File
The Admin Entity Add/Edit Form UI Component `custom_entity_form.xml` is placed in the `view/adminhtml/ui_component` directory
```xml
<?xml version="1.0" ?>
<form xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Ui:etc/ui_configuration.xsd">
    <argument name="data" xsi:type="array">
        <item name="js_config" xsi:type="array">
            <item name="provider" xsi:type="string">custom_entity_form.custom_entity_form_data_source</item>
            <item name="deps" xsi:type="string">custom_entity_form.custom_entity_form_data_source</item>
        </item>
        <item name="label" translate="true" xsi:type="string">General Information</item>
        <item name="config" xsi:type="array">
            <item name="dataScope" xsi:type="string">data</item>
            <item name="namespace" xsi:type="string">custom_entity_form</item>
        </item>
        <item name="template" xsi:type="string">templates/form/collapsible</item>
        <item name="buttons" xsi:type="array">
            <item name="back" xsi:type="string">CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit\BackButton</item>
            <item name="save" xsi:type="string">CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit\SaveButton</item>
            <item name="save_and_continue" xsi:type="string">CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit\SaveAndContinueButton</item>
        </item>
    </argument>
    <dataSource name="custom_entity_form_data_source">
        <argument name="dataProvider" xsi:type="configurableObject">
            <argument name="class" xsi:type="string">CodingTask\ModuleName\Model\CustomEntity\DataProvider</argument>
            <argument name="name" xsi:type="string">custom_entity_form_data_source</argument>
            <argument name="primaryFieldName" xsi:type="string">entity_id</argument>
            <argument name="requestFieldName" xsi:type="string">entity_id</argument>
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="submit_url" path="*/*/save" xsi:type="url"/>
                </item>
            </argument>
        </argument>
        <argument name="data" xsi:type="array">
            <item name="js_config" xsi:type="array">
                <item name="component" xsi:type="string">Magento_Ui/js/form/provider</item>
            </item>
        </argument>
    </dataSource>
    <fieldset name="General">
        <argument name="data" xsi:type="array">
            <item name="config" xsi:type="array">
                <item name="label" xsi:type="string"/>
            </item>
        </argument>
        <field name="code">
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="dataType" xsi:type="string">text</item>
                    <item name="label" translate="true" xsi:type="string">code</item>
                    <item name="formElement" xsi:type="string">textarea</item>
                    <item name="source" xsi:type="string">custom_entity</item>
                    <item name="sortOrder" xsi:type="number">20</item>
                    <item name="dataScope" xsi:type="string">code</item>
                    <item name="validation" xsi:type="array">
                        <item name="required-entry" xsi:type="boolean">false</item>
                    </item>
                </item>
            </argument>
        </field>
        <field name="name">
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="dataType" xsi:type="string">text</item>
                    <item name="label" translate="true" xsi:type="string">name</item>
                    <item name="formElement" xsi:type="string">textarea</item>
                    <item name="source" xsi:type="string">custom_entity</item>
                    <item name="sortOrder" xsi:type="number">30</item>
                    <item name="dataScope" xsi:type="string">name</item>
                    <item name="validation" xsi:type="array">
                        <item name="required-entry" xsi:type="boolean">false</item>
                    </item>
                </item>
            </argument>
        </field>
        <field name="description">
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="dataType" xsi:type="string">text</item>
                    <item name="label" translate="true" xsi:type="string">description</item>
                    <item name="formElement" xsi:type="string">textarea</item>
                    <item name="source" xsi:type="string">custom_entity</item>
                    <item name="sortOrder" xsi:type="number">40</item>
                    <item name="dataScope" xsi:type="string">description</item>
                    <item name="validation" xsi:type="array">
                        <item name="required-entry" xsi:type="boolean">false</item>
                    </item>
                </item>
            </argument>
        </field>
    </fieldset>
</form>
```

### Layout Handle Files
The Admin Entity Add Layout Handle File `custom_entity_add.xml` is placed in the `view/adminhtml/layout` directory
```xml
<?xml version="1.0" ?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <update handle="codingtask_modulename_custom_entity_edit"/>
</page>
```

The Admin Entity Edit Layout Handle File `custom_entity_edit.xml` is placed in the `view/adminhtml/layout` directory
```xml
<?xml version="1.0" ?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="content">
            <uiComponent name="custom_entity_form"/>
        </referenceContainer>
    </body>
</page>
```

### Admin Controller Actions
The Admin Controller Action Abstract Class `Entity.php` is placed in the `Controller/Adminhtml` directory
```php
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
```

The Admin Controller Action `Add.php` is placed in the `Controller/Adminhtml/Entity` directory
```php
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
```

The Admin Controller Action `Edit.php` is placed in the `Controller/Adminhtml/Entity` directory
```php
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
```

The Admin Controller Action `Save.php` is placed in the `Controller/Adminhtml/Entity` directory
```php
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
```

### Add/Edit Form Block Classes
The Admin Add/Edit Form Block `GenericButton.php` is placed in the `Block/Adminhtml/CustomEntity/Edit` directory 
```php
<?php

namespace CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit;

use Magento\Backend\Block\Widget\Context;

/**
 * Class GenericButton
 * @package CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit
 */
abstract class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * Return model ID
     *
     * @return int|null
     */
    public function getModelId()
    {
        return $this->context->getRequest()->getParam('entity_id');
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
```

The Admin Add/Edit Form Block `BackButton.php` is placed in the `Block/Adminhtml/CustomEntity/Edit` directory 
```php
<?php

namespace CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class BackButton
 * @package CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit
 */
class BackButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}
```

The Admin Add/Edit Form Block `SaveButton.php` is placed in the `Block/Adminhtml/CustomEntity/Edit` directory 
```php
<?php

namespace CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 * @package CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Custom Entity'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
```

The Admin Add/Edit Form Block `SaveAndContinueButton.php` is placed in the `Block/Adminhtml/CustomEntity/Edit` directory 
```php
<?php

namespace CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveAndContinueButton
 * @package CodingTask\ModuleName\Block\Adminhtml\CustomEntity\Edit
 */
class SaveAndContinueButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'saveAndContinueEdit'],
                ],
            ],
            'sort_order' => 80,
        ];
    }
}
```

## Research and Useful Links Section
[Magento Guide: UI Components](http://devdocs.magento.com/guides/v2.1/ui_comp_guide/bk-ui_comps.html)