<?php

namespace Maxime\Jobs\Controller\Adminhtml\Job;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Maxime\Jobs\Model\Job;

/**
 * Class Delete
 * @package Maxime\Jobs\Controller\Adminhtml\Job
 */
class Delete extends Action
{

    /**
     * @var Job $_model
     */
    protected $_model;

    /**
     * @param Action\Context $context
     * @param Job $model
     */
    public function __construct(
        Action\Context $context,
        Job $model
    ) {
        parent::__construct($context);
        $this->_model = $model;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Maxime_Jobs::job_delete');
    }

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_model;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Job deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('Job does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}
