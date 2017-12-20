# Custom logger

Magento 2 Snippet: Custom logger.
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 30 mins  
**Task Type:** Modifier
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)

## Task Objectives
- Add custom logger
 
## Instructions
1. Create `Logger` directory inside the module 
2. Implement logger handler class
3. Implement logger class
4. Inject logger handler to logger via `di.xml` 
5. Inject logger to some of existing class

### Logger Handler file  
The logger handler file (`Handler.php`) resides in the module `Logger` directory. 
Filename path should be relative for base Magento directory.
Logger type points to the minimum level of logs that will be logged.  
```php
<?php
 
namespace CodingTask\ModuleName\Logger;
 
use Monolog\Logger;
use Magento\Framework\Logger\Handler\Base;
 
/**
 * Class Handler
 * @package CodingTasks\ModuleName\Logger
 */
class Handler extends Base
{
    /**
     * Define Logger level
     * @var int
     */
    protected $loggerType = Logger::ERROR;
 
    /**
     * Define logger output file
     * @var string
     */
    protected $fileName = 'var/log/custom-logger.log';
}
```

### Logger file  
The logger file (`Logger.php`) resides in the module `Logger` directory. 
This could be an empty class. Theoretically in this case we could use VirtualType for it, but only in case when we will be injecting it through `di.xml` to existing classes. In this case we want to inject it through existing class constructor, so we need to create a real class.
```php
<?php
 
namespace CodingTask\ModuleName\Logger;
 
/**
 * Class Logger
 * @package CodingTasks\ModuleName\Logger
 */
class Logger extends \Monolog\Logger
{
}
```

### Injecting Logger Handler to Logger
Injecting Handler to logger in `di.xml` file resides in `etc` directory.
As you see below, `handlers` argument is in fact an array, so feel free to add more than one logger handler - e.g. to store different log levels in different files.
```xml
<!-- SOME OTHER CODE -->
<type name="CodingTask\ModuleName\Logger\Logger">
    <arguments>
        <argument name="name" xsi:type="string">customLogger</argument>
        <argument name="handlers" xsi:type="array">
            <item name="system" xsi:type="object">CodingTask\ModuleName\Logger\Handler</item>
        </argument>
    </arguments>
</type>
<!-- SOME OTHER CODE -->
```

### Example of usage in existing class
Add logger dependency to existing class and assign it to class property:
```php
/**
 * @var \CodingTask\ModuleName\Logger\Logger
 */
private $logger;
 
/**
 * @param \CodingTask\ModuleName\Logger\Logger  $logger
 */
public function __construct(
    \CodingTask\ModuleName\Logger\Logger $logger
) {
    $this->logger = $logger;
}
```
Log whatever and wherever you want inside your class:
```php
$this->logger->error('Example logger message');
```

##Snippet
Sometimes you don't want to create entire logger functionality, but only log something for a moment like you did it in Magento 1 with simple `Mage::log()`.
The best and simplest solution is to set this piece of code to your `Code templates`:
```php
$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/custom_name.log');
$log = new \Zend\Log\Logger();
$log->addWriter($writer);
$log->debug(__METHOD__);
$log->debug(__LINE__);
``` 

## Additional information
- [VirtualTypes](https://alanstorm.com/magento_2_object_manager_virtual_types/)
- [Argument Replacement](https://alanstorm.com/magento_2_object_manager_argument_replacement/)
