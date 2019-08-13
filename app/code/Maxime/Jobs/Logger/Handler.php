<?php

namespace Maxime\Jobs\Logger;

use Magento\Framework\Logger\Handler\Base;

/**
 * Class Handler
 * @package Maxime\Jobs\Logger
 */
class Handler extends Base
{

    /**
     * Logging level
     * @var int $loggerType
     */
    protected $loggerType = \Monolog\Logger::DEBUG;

    /**
     * File name
     * @var string $fileName
     */
    protected $fileName = '/var/log/maxime_jobs.log';
}
