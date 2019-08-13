<?php

namespace Maxime\Jobs\Controller\Job;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Maxime\Jobs\Logger\Logger;

/**
 * Class TestLog
 * @package Maxime\Jobs\Controller\Job
 */
class TestLog extends Action
{
    /**
     * Logger
     *
     * @var Logger $_logger
     */
    protected $_logger;

    /**
     * @param Context $context
     * @param Logger $logger
     */
    public function __construct(
        Context $context,
        Logger $logger
    ) {
        $this->_logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $this->_logger->addDebug('My debug log');
        $this->_logger->addInfo('My info log');
        $this->_logger->addNotice('My notice log');
        $this->_logger->addWarning('My warning log');
        $this->_logger->addError('My error log');
        $this->_logger->addCritical('My critical log');
        $this->_logger->addAlert('My alert log');
        $this->_logger->addEmergency('My emergency log');

        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
