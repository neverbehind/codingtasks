# Custom Entity - Custom JS

Magento 2 Extension: Add custom JS to block.
 
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
7. Block on product page - [Create Entity - Display on product page](/magento2/create-entity-display-product-page).

## Task Objectives
- Add custom JS to block
 
## Instructions
1. Create `web/js` directory inside the module `view/frontend` directory 
2. Implement JS library
3. Define RequireJS config
4. Call JS library in block template

### JS Library file  
The JS library file (`custom-library.js`) resides in the module `view/frontend/web/js` directory.  
```js
define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/translate'
], function($, modal, $t) {
    'use strict';
 
    $.widget('mage.customLibrary', {
        modalContainer: undefined,
 
        options: {
            foo: undefined
        },
 
        /**
         * @private
         */
        _create: function() {
            this.bindAction();
            this.initModal();
        },
 
        /**
         */
        bindAction: function() {
            this.element.on('click', this.onButtonClick.bind(this));
        },
 
        /**
         */
        onButtonClick: function() {
            this.modalContainer.modal('openModal');
        },
 
        /**
         */
        initModal: function() {
            var options = {
                'type': 'popup',
                'modalClass': 'custom-popup',
                'responsive': true,
                'buttons': []
            };
 
            this.modalContainer = this.getModalContent();
            modal(options, this.modalContainer);
        },
 
        /**
         * @returns {*|jQuery}
         */
        getModalContent: function() {
            return $('<div/>').append($('<p/>').text(this.options.foo.name));
        }
    });
 
    return $.mage.customLibrary;
});
```

### RequireJS config file
The JS library file (`requirejs-config.js`) resides in the module `view/frontend` directory.
```js
var config = {
    map: {
        "*": {
            customLibrary: 'CodingTask_ModuleName/js/custom-library'
        }
    }
};
```

### Modified block template
Modified existing custom block template to add JS initialization:
```php
<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */
?>
<?php /** @var \CodingTask\ModuleName\Block\DisplayEntity $block */ ?>
<div class="box">
    <h3><?php echo $block->getCustomEntity()->getName() ?></h3>
    <p>
        <?php echo $block->getCustomEntity()->getDescription() ?>
    </p>
    <div class="action">
        <button name="submit" class="action" type="button"
                data-mage-init='{"customLibrary":{"foo":<?php echo json_encode($block->getCustomEntity()->getData()) ?>}}'>
            <span><?php echo __('Show') ?></span>
        </button>
    </div>
</div>
```

## Research and Useful Links Section
- [Magento Tutorial](http://devdocs.magento.com/guides/v2.1/javascript-dev-guide/javascript/js_init.html)