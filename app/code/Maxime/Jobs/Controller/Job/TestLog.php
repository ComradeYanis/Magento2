<?php

namespace Maxime\Jobs\Controller\Job;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Psr\Log\LoggerInterface;

/**
 * Class TestLog
 * @package Maxime\Jobs\Controller\Job
 */
class TestLog extends Action
{

    /**
     * @var LoggerInterface $_logger
     */
    protected $_logger;

    /**
     * TestLog constructor.
     * @param Context $context
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger
    ) {
        $this->_logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        var_dump(get_class($this->_logger));

        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
