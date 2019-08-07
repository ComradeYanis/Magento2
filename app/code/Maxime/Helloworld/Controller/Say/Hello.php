<?php

namespace Maxime\Helloworld\Controller\Say;

use Magento\Framework\App\Action\Action;

/**
 * Class Index
 * @package Maxime\Helloworld\Controller\Say
 */
class Hello extends Action
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
        echo 'Say "Hello"! I`m win!';
        die;
    }
}
