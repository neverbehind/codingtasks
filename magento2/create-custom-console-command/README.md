# Custom CLI Command

Magento 2 Custom CLI/Console Command
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** .5 hours  
**Task Type:** Base
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)

## Task Objectives
- Add custom CLI command to be used in scope of bin/magento
 
## Instructions
1. Create Shell Console Command class
1. Create DI Directive, registering command in the command list

### Shell Console Command class
```
<?php
...
namespace Guidance\Shell\Console\Command;

use Symfony\Component\Console\Command\Command as Command;
use Symfony\Component\Console\Input\InputInterface as InputInterface;
use Symfony\Component\Console\Output\OutputInterface as OutputInterface;
use Symfony\Component\Console\Input\InputArgument as InputArgument;

...

class LastOrderCommand extends Command
{

    ...
    
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        // Setup the command configuration
        $this->setName('guidance-shell:last_order');
        $this->setDescription('Gets the datetime of the last order placed');
        $this->addArgument(self::ARG_STORE_ID, InputArgument::OPTIONAL, 'Store ID');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
      // Logic to execute 
    }
}

```

### DI Directive
```
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <type name="Magento\Framework\Console\CommandListInterface">
        <arguments>
            <argument name="commands" xsi:type="array">
                <item name="last_order" xsi:type="object">Guidance\Shell\Console\Command\LastOrderCommand</item>
            </argument>
        </arguments>
    </type>
</config>

```

## Usage / Examples

From the Magento root directory, and as the web server user, you can execute this sample command

`$ bin/magento last_order --store_id [integer]`

## Research and Useful Links Section
[Magento Guide: Magento CLI](http://devdocs.magento.com/guides/v2.0/extension-dev-guide/cli-cmds/cli-howto.html)
