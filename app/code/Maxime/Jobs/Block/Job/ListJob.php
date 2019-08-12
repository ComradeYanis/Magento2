<?php

namespace Maxime\Jobs\Block\Job;

use Magento\Framework\View\Element\Template;
use Maxime\Jobs\Model\Job;

/**
 * Class ListJob
 * @package Maxime\Jobs\Block\Job
 */
class ListJob extends Template
{

    /**
     * @var Job $_job
     */
    protected $_job;

    protected $_department;

    protected $_resource;

    protected $jobCollection = null;
}
