<?php

namespace Maxime\Jobs\Controller\Job;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Maxime\Jobs\Model\Job;

/**
 * Class View
 * @package Maxime\Jobs\Controller\Job
 */
class View extends Action
{

    /**
     * @var Job $_model
     */
    protected $_model;

    /**
     * View constructor.
     * @param Context $context
     * @param Job $model
     */
    public function __construct(
        Context $context,
        Job $model
    ) {
        $this->_model = $model;
        parent::__construct($context);
    }

    public function execute()
    {
        $id     = $this->getRequest()->getParam('id');
        $model  = $this->_model;

        if (empty($id)) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        $model->load($id);

        if (!$model->getId()) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
