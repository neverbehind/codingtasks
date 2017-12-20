# Custom Entity - Display on product page

Magento 2 Extension: Display on product page.
 
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
- Add custom entity information on product page
 
## Instructions
1. Create `Block`, `view/frontend/layout` and `view/frontend/templates` directories inside the module 
2. Implement Block class
3. Implement block template
4. Embed custom block on product page

### Block class file  
The Block class file (`DisplayEntity.php`) resides in the module `Block` directory. 
```php
<?php
 
namespace CodingTask\ModuleName\Block;
 
use CodingTask\ModuleName\Api\CustomEntityRepositoryInterface;
use CodingTask\ModuleName\Model\CustomEntityFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
 
/**
 * Class DisplayEntity
 * @package CodingTask\ModuleName\Block
 */
class DisplayEntity extends Template
{
    /**
     * @var \CodingTask\ModuleName\Api\CustomEntityRepositoryInterface
     */
    private $customEntityRepository;
    /**
     * @var \CodingTask\ModuleName\Block\CustomEntityFactory
     */
    private $customEntityFactory;
 
    /**
     * Block constructor.
     *
     * @param \CodingTask\ModuleName\Api\CustomEntityRepositoryInterface $customEntityRepository
     * @param \CodingTask\ModuleName\Model\CustomEntityFactory           $customEntityFactory
     * @param \Magento\Framework\View\Element\Template\Context           $context
     * @param array                                                      $data
     */
    public function __construct(
        CustomEntityRepositoryInterface $customEntityRepository,
        CustomEntityFactory $customEntityFactory,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customEntityRepository = $customEntityRepository;
        $this->customEntityFactory = $customEntityFactory;
    }
 
    /**
     * @return \CodingTask\ModuleName\Api\Data\CustomEntityInterface
     */
    public function getCustomEntity()
    {
        $id = 1; // Hardcoded for example purpose.
        try {
            return $this->customEntityRepository->get($id);
        } catch (NoSuchEntityException $e) {
            return $this->customEntityFactory->create();
        }
    }
}
```

### Block template file
The block template file `display_entity.phtml` resides in the module `view/frontend/templates` directory.
```php
<?php /** @var \CodingTask\ModuleName\Block\DisplayEntity $block */ ?>
<div class="box">
    <h3><?php echo $block->getCustomEntity()->getName() ?></h3>
    <p>
        <?php echo $block->getCustomEntity()->getDescription() ?>
    </p>
</div>
```

### Layout file
The layout file `catalog_product_view.xml` resides in the module `view/frontend/layout` directory.
```xml
<?xml version="1.0"?>
 
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="content">
            <block class="CodingTask\ModuleName\Block\DisplayEntity"
                    name="custom_entity"
                    template="display_entity.phtml"/>
        </referenceContainer>
    </body>
</page>
```