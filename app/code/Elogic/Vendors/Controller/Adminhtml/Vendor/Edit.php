<?php

namespace Elogic\Vendors\Controller\Adminhtml\Vendor;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Elogic\Vendors\Model\Vendor;

/**
 * Class Edit
 * @package Elogic\Vendors\Controller\Adminhtml\Vendor
 */
class Edit extends Action
{
    /**
     * Core registry
     *
     * @var Registry $_coreRegistry
     */
    protected $_coreRegistry = null;

    /**
     * @var PageFactory $_resultPageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var Vendor $_model
     */
    protected $_model;

    /**
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     * @param Vendor $model
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        Vendor $model
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->_model = $model;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Elogic_Vendors::vendor_save');
    }

    /**
     * Init actions
     *
     * @return Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Elogic_Vendors::vendor')
            ->addBreadcrumb(__('Vendor'), __('Vendor'))
            ->addBreadcrumb(__('Manage Vendors'), __('Manage Vendors'));
        return $resultPage;
    }

    /**
     * Edit Vendor
     *
     * @return Page|Redirect|\Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_model;

        // If you have got an id, it's edition
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This vendor not exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('vendors_vendor', $model);

        /** @var Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Vendor') : __('New Vendor'),
            $id ? __('Edit Vendor') : __('New Vendor')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Vendors'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getName() : __('New Vendor'));

        return $resultPage;
    }
}
