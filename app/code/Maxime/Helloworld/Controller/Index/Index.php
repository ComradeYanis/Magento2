<?php

namespace Maxime\Helloworld\Controller\Index;

use Magento\Framework\App\Action\Action;

/**
 * Class Index
 * @package Maxime\Helloworld\Controller\Index
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
        echo 'Hello! I`m win!';
        die;
    }
}
