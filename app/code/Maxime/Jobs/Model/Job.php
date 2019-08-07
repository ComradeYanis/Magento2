<?php

namespace Maxime\Jobs\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Job
 * @package Maxime\Jobs\Model
 */
class Job extends AbstractModel
{
    /**
     * @const JOB_ID
     */
    const JOB_ID = 'entity_id';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'jobs';

    /**
     * Name of the event object
     *
     * @var string
     */
    protected $_eventObject = 'job';

    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = self::JOB_ID;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Job::class);
    }
}
