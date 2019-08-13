<?php

namespace Maxime\Jobs\Controller\Cookie;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Stdlib\Cookie\FailureToSendException;
use Magento\Framework\Stdlib\CookieManagerInterface;

/**
 * Class Testdeletecookie
 * @package Maxime\Jobs\Controller\Cookie
 */
class Testdeletecookie extends Action
{

    /**
     * @var CookieManagerInterface $_cookieManager
     */
    protected $_cookieManager;

    /**
     * Testdeletecookie constructor.
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
     * @throws InputException
     * @throws FailureToSendException
     */
    public function execute()
    {
        $this->_cookieManager->deleteCookie(Testaddcookie::JOB_COOKIE_NAME);
        echo('Cookie has been deleted');
    }
}
