<?php

namespace Maxime\Jobs\Controller\Department;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Maxime\Jobs\Model\Department;

/**
 * Class View
 * @package Maxime\Jobs\Controller\Department
 */
class View extends Action
{

    /**
     * @var Department $_model
     */
    protected $_model;

    /**
     * View constructor.
     * @param Context $context
     * @param Department $model
     */
    public function __construct(
        Context $context,
        Department $model
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
