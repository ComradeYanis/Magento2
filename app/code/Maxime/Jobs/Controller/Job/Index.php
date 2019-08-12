<?php

namespace Maxime\Jobs\Controller\Job;

use Magento\Framework\App\Action\Action;

/**
 * Class Index
 * @package Maxime\Jobs\Controller\Job
 */
class Index extends Action
{

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
