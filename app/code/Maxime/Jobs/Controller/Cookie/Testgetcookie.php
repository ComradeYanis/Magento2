<?php

namespace Maxime\Jobs\Controller\Cookie;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Stdlib\CookieManagerInterface;

/**
 * Class Testgetcookie
 * @package Maxime\Jobs\Controller\Cookie
 */
class Testgetcookie extends Action
{

    /**
     * @var CookieManagerInterface $_cookieManager
     */
    protected $_cookieManager;

    /**
     * Testgetcookie constructor.
     * @param Context $context
     * @param CookieManagerInterface $cookieManager
     */
    public function __construct(
        Context $context,
        CookieManagerInterface $cookieManager
    ) {
        $this->_cookieManager = $cookieManager;

        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return void
     */
    public function execute()
    {
        $cookieValue = $this->_cookieManager->getCookie(Testaddcookie::JOB_COOKIE_NAME);
        echo($cookieValue);
    }
}
