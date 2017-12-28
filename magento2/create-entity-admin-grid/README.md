# Custom Entity - Admin Grid - UI Component

Magento 2 Custom Entity Admin Management Grid.
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 1 hour
**Task Type:** Base
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)
2. Setup install scripts - [Setup install Schema and Data](/magento2/setup-install-schema-data).
3. Database table - [Create Entity - database table](/magento2/create-entity-table).
4. Model and collection - [Create Entity - model and collection](/magento2/create-entity-model-collection).
5. API Data structure - [Create Entity - API Data structure](/magento2/create-entity-api-data-structure).
6. Repository - [Create Entity - Repository](/magento2/create-entity-repository).

## Task Objectives
- Add custom entity grid for displaying data in admin
 
## Instructions
1. Create Grid Collection Class
1. Define UI Component Datasource in di.xml 
1. Create UI Component Definition File
1. Create Layout Directive
1. Create Admin Controller
1. Admin Route to Controller

### Grid Collection Class
The Grid Collection Class file `Collection.php` is placed in the `Model/Resource/CustomerEntity/Grid` directory
```php
<?php

namespace CodingTask\ModuleName\Model\Resource\CustomEntity\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use CodingTask\ModuleName\Model\Resource\CustomEntity;
use Psr\Log\LoggerInterface as Logger;

/**
 * Class Collection
 * @package CodingTask\ModuleName\Model\Resource\CustomEntity\Grid
 */
class Collection extends SearchResult
{
    /**
     * Collection constructor.
     *
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface    $entityFactory
     * @param \Psr\Log\LoggerInterface                                     $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface                    $eventManager
     * @param string                                                       $mainTable
     * @param string                                                       $resourceModel
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable = 'custom_entity',
        $resourceModel = CustomEntity::class
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }

    /**
     * @return $this
     */
    protected function _beforeLoad()
    {
        // Business/Data Relation Logic goes here
        // e.g. $this->join(['ot' => 'other_table'], 'main_table.foreign_id=ot.entity_id', 'field');

        return parent::_beforeLoad();
    }

}
```

### UI Component Datasource Directive
The UI Component Datasource Directive is placed in the `di.xml` in the modules `etc` directory
```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">

    <!-- Other di.xml content -->
    <type name="Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory">
        <arguments>
            <argument name="collections" xsi:type="array">
                <item name="custom_entity_listing_data_source" xsi:type="string">CodingTask\ModuleName\Model\Resource\CustomEntity\Grid\Collection</item>
            </argument>
        </arguments>
    </type>
    <!-- Other di.xml content -->
</config>
```

### UI Component Definition File
The Admin Grid UI Component `custom_entity_listing.xml` is placed in the `view/adminhtml/ui_component` directory
```xml
<?xml version="1.0" encoding="UTF-8"?>
<listing xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Ui:etc/ui_configuration.xsd">

    <argument name="data" xsi:type="array">
        <item name="js_config" xsi:type="array">
            <item name="provider" xsi:type="string">custom_entity_listing.custom_entity_listing_data_source</item>
            <item name="deps" xsi:type="string">custom_entity_listing.custom_entity_listing_data_source</item>
        </item>
        <item name="spinner" xsi:type="string">custom_entity_columns</item>
        <item name="acl" xsi:type="string">CodingTask_ModuleName::admin</item>
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

### Layout Handle File
The Admin Grid Layout Handle File `custom_entity_index.xml` is placed in the `view/adminhtml/layout` directory
```xml
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="content">
            <uiComponent name="custom_entity_listing"/>
        </referenceContainer>
    </body>
</page>
```

### Admin Controller
The Admin Controller `Index.php` is placed in the `Controller/Adminhtml/Entity` directory
```php
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
```

### Admin Route

An admin route file `routes.xml` is placed in the `etc/adminhtml` directory 

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:App/etc/routes.xsd">
    <router id="admin">
        <route id="custom" frontName="custom">
            <module name="CodingTask_ModuleName" />
        </route>
    </router>
</config>
```