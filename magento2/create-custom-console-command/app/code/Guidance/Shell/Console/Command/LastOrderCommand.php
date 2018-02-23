<?php
/**
 * Guidance Shell
 *
 * @author      Guidance Magento Team <magento@guidance.com>
 * @category    Guidance
 * @package     Shell
 * @copyright   Copyright (c) 2018 Guidance Solutions (http://www.guidance.com)
 */
namespace Guidance\Shell\Console\Command;

use Symfony\Component\Console\Command\Command as Command;
use Symfony\Component\Console\Input\InputInterface as InputInterface;
use Symfony\Component\Console\Output\OutputInterface as OutputInterface;
use Symfony\Component\Console\Input\InputArgument as InputArgument;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

/**
 * Class LastOrderCommand
 * @package Guidance\Shell\Console\Command
 */
class LastOrderCommand extends Command
{
    const ARG_STORE_ID = 'store_id';
    /**
     * @var OrderCollectionFactory
     */
    private $_orderCollectionFactory;

    /**
     * @param OrderCollectionFactory $orderCollectionFactory
     */
    public function __construct(
        OrderCollectionFactory $orderCollectionFactory
    )
    {
        parent::__construct();

        $this->_orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('guidance-shell:last_order');
        $this->setDescription('Gets the datetime of the last order placed');
        $this->addArgument(self::ARG_STORE_ID, InputArgument::OPTIONAL, 'Store ID');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $storeId = $input->getArgument(self::ARG_STORE_ID);
        /** @var \Magento\Sales\Model\ResourceModel\Order\Collection $orderCollection */
        $orderCollection = $this->_orderCollectionFactory->create();
        if (!empty($storeId)) {
            $orderCollection->addFieldToFilter('store_id', ['eq' => intval($storeId)]);
        }
        $orderCollection->setOrder('created_at');
        $orderCollection->getSelect()->limit(1);
        /** @var \Magento\Sales\Model\Order $lastOrder */
        $lastOrder = $orderCollection->getFirstItem();

        $output->writeln($lastOrder->getCreatedAt());
    }
}
