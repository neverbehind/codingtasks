# Enable Database Debug Logs

Turn on a log of all database calls made from the Magento 2 application

## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 5 mins  
**Task Type:** Modifier

## Pre requirements
- Extension with `di.xml`

## Task Objectives
- All MySQL Statements should be logged to a log file in `var/debug/db.log`

## Instructions
Add DI Preference Directive in any `di.xml` of the project

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">

<!-- SOME OTHER CODE -->

    <preference for="Magento\Framework\DB\LoggerInterface" type="Magento\Framework\DB\Logger\File"/>
    <type name="Magento\Framework\DB\Logger\File">
       <arguments>
           <argument name="logAllQueries" xsi:type="boolean">true</argument>
           <argument name="debugFile" xsi:type="string">debug/db.log</argument>
       </arguments>
    </type>

<!-- SOME OTHER CODE -->

</config>
```
 
## Research and Useful Links Section
[Atwix Blog - Database queries logging in Magento 2](https://www.atwix.com/magento-2/database-queries-logging/)
