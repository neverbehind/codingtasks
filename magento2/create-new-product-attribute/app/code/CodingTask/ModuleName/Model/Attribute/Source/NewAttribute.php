<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

namespace CodingTask\ModuleName\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class NewAttribute
 * @package CodingTask\ModuleName\Model\Attribute\Source
 */
class NewAttribute extends AbstractSource
{
    /**
     * Get all options
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __('Option 1'), 'value' => 0],
                ['label' => __('Option 2'), 'value' => 1],
                ['label' => __('Option 3'), 'value' => 2]
            ];
        }

        return $this->_options;
    }
}