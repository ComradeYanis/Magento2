<?php

namespace Maxime\Jobs\Controller\Adminhtml\Job;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Forward;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class NewAction
 * @package Maxime\Jobs\Controller\Adminhtml\Job
 */
class NewAction extends Action
{
    /**
     * @var Forward $_resultForwardFactory
     */
    protected $_resultForwardFactory;

    public function __construct(Action\Context $context, ForwardFactory $_resultForwardFactory)
    {
        $this->_resultForwardFactory = $_resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Maxime_Jobs::job_save');
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        /** @var Forward $resultForward */
        $resultForward = $this->_resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
