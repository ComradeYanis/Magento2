<?php

namespace Elogic\Vendors\Controller\Adminhtml\Vendor;

use Elogic\Vendors\Model\Vendor;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Filesystem\Driver\File;

/**
 * Class Delete
 * @package Elogic\Vendors\Controller\Adminhtml\Vendor
 */
class Delete extends Action
{

    /**
     * @var Vendor $_model
     */
    protected $_model;

    /**
     * @var File $_file
     */
    protected $_file;

    /**
     * @param Action\Context $context
     * @param Vendor $model
     * @param File $file
     */
    public function __construct(
        Action\Context $context,
        Vendor $model,
        File $file
    ) {
        parent::__construct($context);
        $this->_model   = $model;
        $this->_file    = $file;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Elogic_Vendors::vendor_delete');
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
                $logo = $model->getLogo();
                if (isset($logo) && strlen($logo)) {
                    try {
                        $this->_file->deleteFile($logo);
                    } catch (Exception $e) {
                        $this->messageManager->addError($e->getMessage());
                    }
                }
                $model->delete();
                $this->messageManager->addSuccess(__('Vendor deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('Vendor does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}
