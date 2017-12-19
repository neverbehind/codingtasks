# Create a new product attribute

Magento 2 Extension: Create a new product attribute.
 
## Task Details  
**Platform/Framework:** Magento 2  
**Development Hours:** 1 hour  
**Task Type:** Modifier
 
## Pre requirements
1. Skeleton of Magento 2 module - [Create Extension](/magento2/create-extension)
2. Setup install scripts - [Setup install Schema and Data](/magento2/setup-install-schema-data).

## Task Objectives
- Add new product attribute
 
## Instructions
1. Define new attribute options in InstallData file
2. Implement needed models for defined attribute
3. Run `php bin/magento setup:upgrade` from the Magento root directory to trigger the module installation
4. Verify if attribute exists

### Defining new attribute options in InstallData file
Open `InstallData.php` file (created before), add `Magento\Eav\Setup\EavSetupFactory` to `InstallData` dependencies:
```php
/**
 * @var \Magento\Eav\Setup\EavSetupFactory
 */
private $eavSetupFactory;
 
/**
 * InstallData constructor.
 *
 * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
 */
public function __construct(
   \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
) {
    $this->eavSetupFactory = $eavSetupFactory;
}
```

Define new attribute in `install` method:
```php
/**
 * {@inheritdoc}
 */
public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
{
    $setup->startSetup();
 
    /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
    $eavSetup = $this->eavSetupFactory->create();
    $eavSetup->addAttribute(
        \Magento\Catalog\Model\Product::ENTITY, 
        'custom_attribute', 
        [
            'group' => 'General',
            'type' => 'varchar',
            'label' => 'New custom attribute',
            'input' => 'select',
            'source' => 'CodingTask\ModuleName\Model\Attribute\Source\NewAttribute',
            'required' => false,
            'sort_order' => 100,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => true,
            'is_filterable_in_grid' => true,
            'visible' => true,
            'is_html_allowed_on_front' => true,
            'visible_on_front' => true
        ]);
 
    $setup->endSetup();
}
``` 
## Research and Useful Links Section
[Magento Tutorial](http://devdocs.magento.com/videos/fundamentals/add-new-product-attribute/)
