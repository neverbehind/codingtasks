# Create a Magento Extension

Magento 2 Extension Shell or Skeleton
 
## Task Details  

**Platform/Framework:** Magento 2  
**Development Hours:** 30 mins  
**Task Type:** Base
 
## Task Objectives

- A shell extension that can be filled with functionality 
 
## Instructions

1. Create registration file
1. Create the module definition file

### Registration File

The module `registration.php` file resides in the modules base directory.

```php
<?php
   
   \Magento\Framework\Component\ComponentRegistrar::register(
       \Magento\Framework\Component\ComponentRegistrar::MODULE,
       'CodingTask_ModuleName',
       __DIR__
   );
```

### Module Definition 

The module definition resides in the modules `etc` directory.

```xml
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:module/etc/module.xsd">
    <module name="CodingTask_ModuleName" setup_version="1.0.0" />
</config>
```
     
 
## Research and Useful Links Section
[Magento Tutorial](http://devdocs.magento.com/videos/fundamentals/create-a-new-module/)
 
