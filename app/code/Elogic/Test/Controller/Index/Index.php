<?php


namespace Elogic\Test\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Maxime\Jobs\Controller\Job
 */
class Index extends Action
{

    /**
     * @var PageFactory $_pageFactory
     */
    protected  $_pageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return Page
     */
    public function execute()
    {
        $resultPageFactory = $this->_pageFactory->create();
        return $resultPageFactory;
    }
}