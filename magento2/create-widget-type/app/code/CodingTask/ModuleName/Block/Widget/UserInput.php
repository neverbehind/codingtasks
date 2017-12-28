<?php
namespace CodingTask\ModuleName\Block\Widget;

/**
 * Coding Task User Input Widget
 *
 */
class UserInput extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

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
