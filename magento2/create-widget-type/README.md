# Create a Magento Extension

Magento 2 Extension Shell or Skeleton
 
## Task Details  

Platform/Framework: Magento 2
Development Hours: 30 mins
Task Type: Base

## Prerequisites

- Magento Extension

## Task Objectives

- Basic Widget Type and Block 
 
## Instructions

1. Create widget definition file
1. Create widget block class
1. Create widget block template

### Widget Definition File

The widget definition file `widget.xml` resides in the module's `etc` directory

```xml
<?xml version="1.0" encoding="UTF-8"?>
<widgets xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Widget:etc/widget.xsd">
         <!-- Give the Widget a unique name, and point to the Block Class -->
    <widget id="codingtask_user_input" class="CodingTask\ModuleName\Block\Widget\UserInput">
        <label translate="true">User Input Block</label>
        <description translate="true">Widget that Displays User Input</description>
        <parameters>
            <parameter name="template" xsi:type="select" visible="true" required="true" sort_order="10">
                <label translate="true">Template</label>
                <options>
                    <option name="default" value="widget/template.phtml" selected="true">
                        <label translate="true">Coding Tasks Module Widget Default Template</label>
                    </option>
                </options>
            </parameter>
            <parameter name="user_input" xsi:type="text" visible="true" required="true" sort_order="10">
                <label translate="true">User Input</label>
            </parameter>
        </parameters>
    </widget>
</widgets>
```

### Widget Block Class 

The widget block class contains the preparatory business logic about the widget needs and contains logic for template.

```php
<?php
namespace CodingTask\ModuleName\Block\Widget;

/**
 * Coding Task User Input Widget
 *
 */
class UserInput extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{

    // Constructor and DI Goes Here
 
    /**
     * Prepare widget block output
     *
     * @return $this
     */
    protected function _beforeToHtml()
    {
        // Business Logic Goes Here
        parent::_beforeToHtml();
        // Business Logic Goes Here
        return $this;
    }
    
    /**
     * Output widget block html
     *
     * @return string
     */
    protected function _toHtml()
    {
        // Business Logic Goes Here
        // Check if the widget can even be displayed or do logic checks
        return parent::_toHtml();
    }    
}

```

### Widget Template File

```html
<?php
/**
 * Coding Task User Input Widget Template
 *
 * @var $block \CodingTask\ModuleName\Block\Widget\UserInput
 */
?>
<div class="user-input">
    // $block gets populated with the input from the parameters when an admin creates a widget instance
    <p><?php echo $block->getUserInput(); ?></p>
</div>

```  
 
## Research and Useful Links Section
[Widget Tutorial](https://www.atwix.com/magento-2/adding-a-new-widget/)
