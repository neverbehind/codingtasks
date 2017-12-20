<?php
/**
 * @package     CodingTask_ModuleName
 * @copyright   Copyright ⓒ 2017
 */

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