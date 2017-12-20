<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

namespace CodingTask\ModuleName\Block;

use CodingTask\ModuleName\Api\CustomEntityRepositoryInterface;
use CodingTask\ModuleName\Model\CustomEntityFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class DisplayEntity
 * @package CodingTask\ModuleName\Display
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
        $id = 5; // Hardcoded for example purpose.
        try {
            return $this->customEntityRepository->get($id);
        } catch (NoSuchEntityException $e) {
            return $this->customEntityFactory->create();
        }
    }
}