# Create entity - REST API

Magento 2 Extension: Create entity - REST API.
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 1 hour  
**Task Type:** Modifier
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)
2. Setup install scripts - [Setup install Schema and Data](/magento2/setup-install-schema-data).
3. Database table - [Create Entity - database table](/magento2/create-entity-table).
4. Model and collection - [Create Entity - model and collection](/magento2/create-entity-model-collection).
5. API Data structure - [Create Entity - API Data structure](/magento2/create-entity-api-data-structure).
6. Repository - [Create Entity - Repository](/magento2/create-entity-repository).

## Task Objectives
- Add REST API endpoint
 
## Instructions
1. Extend entity repository interface
2. Update entity repository class
3. Define ACL(Access Control List) in `acl.xml` file
4. Define endpoints in `webapi.xml` file
5. Verify if REST API works as expected

### Extended entity repository interface file
Add `deleteById` method definition to existing exntity repository interface:
```php
/**
 * @param int $id
 * @return bool Will returned True if deleted
 * @throws \Magento\Framework\Exception\NoSuchEntityException
 * @throws \Magento\Framework\Exception\StateException
 */
public function deleteById($id);
```

### Updated entity repository file
Implement `deleteById` method:
```php
/**
 * {@inheritdoc}
 */
public function deleteById($id)
{
    return $this->delete($this->get((int)$id));
}
```

### ACL file  
The ACL file (`acl.xml.php`) resides in the module `etc` directory.  
Thanks to that file administrator will be able to grand or revoke access
```xml
<?xml version="1.0"?>
 
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Acl/etc/acl.xsd">
    <acl>
        <resources>
            <resource id="Magento_Backend::admin">
                <resource id="CodingTask_ModuleName::admin" title="Custom Entity Management" translate="title" sortOrder="100">
                    <resource id="CodingTask_ModuleName::api" title="API" translate="title" sortOrder="100"/>
                </resource>
            </resource>
        </resources>
    </acl>
</config>
```

### WebApi definition file
The `webapi.xml` file which contains definition of API endpoints resides in the module `etc` directory.
```xml
<?xml version="1.0"?>
 
<routes xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Webapi:etc/webapi.xsd">
 
    <route method="POST" url="/V1/customentity">
        <service class="CodingTask\ModuleName\Api\CustomEntityRepositoryInterface" method="save"/>
        <resources>
            <resource ref="CodingTask_ModuleName::api"/>
        </resources>
    </route>
     
    <route method="PUT" url="/V1/customentity/:id">
        <service class="CodingTask\ModuleName\Api\CustomEntityRepositoryInterface" method="save"/>
        <resources>
            <resource ref="CodingTask_ModuleName::api"/>
        </resources>
    </route>
     
    <route method="DELETE" url="/V1/customentity/:id">
        <service class="CodingTask\ModuleName\Api\CustomEntityRepositoryInterface" method="deleteById"/>
        <resources>
            <resource ref="CodingTask_ModuleName::api"/>
        </resources>
    </route>
     
    <route method="GET" url="/V1/customentity">
        <service class="CodingTask\ModuleName\Api\CustomEntityRepositoryInterface" method="getList"/>
        <resources>
            <resource ref="CodingTask_ModuleName::api"/>
        </resources>
    </route>
</routes>
```

### Verify REST API

1. Create new Custom Entity:
    ```bash
    curl -X POST \
      http://<DOMAIN>/rest/V1/customentity \
      -H 'Accept: application/xml' \
      -H 'Authorization: Bearer <TOKEN>' \
      -H 'Cache-Control: no-cache' \
      -H 'Content-Type: application/xml' \
      -d '<?xml version="1.0"?>
    <request>
        <customEntity>
            <code>ABC-code6</code>
            <name>New name of second entity</name>
            <description>Lorem ipsum</description>
        </customEntity>
    </request>'
    ```
2. Update existing Custom Entity:
    ```bash
    curl -X PUT \
      http://<DOMAIN>/rest/V1/customentity/6 \
      -H 'Accept: application/xml' \
      -H 'Authorization: Bearer <TOKEN>>' \
      -H 'Cache-Control: no-cache' \
      -H 'Content-Type: application/xml' \
      -d '<?xml version="1.0"?>
    <request>
        <customEntity>
            <description>Lorem ipsum dolor sit amet</description>
        </customEntity>
    </request>'
    ```
3. Delete Custom Entity:
    ```bash
    curl -X DELETE \
      http://<DOMAIN>/rest/V1/customentity/6 \
      -H 'Accept: application/xml' \
      -H 'Authorization: Bearer <TOKEN>' \
      -H 'Cache-Control: no-cache'
    ```
4. Search Custom Entities:
    ```bash
    curl -X GET \
      'http://<DOMAIN>>/rest/V1/customentity?searchCriteria[pageSize]=10&searchCriteria[currentPage]=1&searchCriteria[filter_groups][0][filters][0][field]=code&searchCriteria[filter_groups][0][filters][0][value]=%25ABC%25&searchCriteria[filter_groups][0][filters][0][condition_type]=like' \
      -H 'Accept: application/xml' \
      -H 'Authorization: Bearer <TOKEN>' \
      -H 'Cache-Control: no-cache'
    ```

## Additional information
Be aware, that Magento 2 uses method definition (and definition of parameters) for converting data (array) from API request to objects.  
Take a look at: `\Magento\Framework\Webapi\ServiceInputProcessor::process` method. 