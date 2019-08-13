<?php

namespace Maxime\Jobs\Controller\Cookie;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\Cookie\CookieSizeLimitReachedException;
use Magento\Framework\Stdlib\Cookie\FailureToSendException;
use Magento\Framework\Stdlib\CookieManagerInterface;

/**
 * Class Testaddcookie
 * @package Maxime\Jobs\Controller\Cookie
 */
class Testaddcookie extends Action
{

    /**
     * @const JOB_COOKIE_NAME
     */
    const JOB_COOKIE_NAME = 'jobs';

    /**
     * life time in seconds
     * @const JOB_COOKIE_DURATION
     */
    const JOB_COOKIE_DURATION = 86400;

    /**
     * @var CookieManagerInterface $_cookieManager
     */
    protected $_cookieManager;

    /**
     * @var CookieMetadataFactory $_cookieMetadataFactory
     */
    protected $_cookieMetadataFactory;

    /**
     * Testaddcookie constructor.
     * @param Context $context
     * @param CookieMetadataFactory $cookieMetadata
     * @param CookieManagerInterface $cookieManager
     */
    public function __construct(
        Context $context,
        CookieMetadataFactory $cookieMetadata,
        CookieManagerInterface $cookieManager
    ) {
        $this->_cookieManager           = $cookieManager;
        $this->_cookieMetadataFactory   = $cookieMetadata;

        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return void
     * @throws InputException
     * @throws CookieSizeLimitReachedException
     * @throws FailureToSendException
     */
    public function execute()
    {
        $metadata = $this->_cookieMetadataFactory
            ->createPublicCookieMetadata()
            ->setDuration(self::JOB_COOKIE_DURATION);

        $this->_cookieManager->setPublicCookie(
            self::JOB_COOKIE_NAME,
            'MY COOKIE VALUE',
            $metadata
        );

        echo('COOKIE IS WORKING!');
    }
}
