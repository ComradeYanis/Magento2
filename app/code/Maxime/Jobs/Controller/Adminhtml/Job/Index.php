<?php
namespace Maxime\Jobs\Controller\Adminhtml\Job;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Maxime\Jobs\Controller\Adminhtml\Job
 */
class Index extends Action
{

    /**
     * @const ADMIN_RESOURCE
     */
    const ADMIN_RESOURCE = 'Maxime_Jobs::job';

    /**
     * @var PageFactory $resultPageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Maxime_Jobs::job');
        $resultPage->addBreadcrumb(__('Jobs'), __('Jobs'));
        $resultPage->addBreadcrumb(__('Manage Jobs'), __('Manage Jobs'));
        $resultPage->getConfig()->getTitle()->prepend(__('Job'));

        return $resultPage;
    }
}
