<?php

namespace Maxime\Jobs\Model\ResourceModel\Job;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Maxime\Jobs\Model\Job;

class Collection extends AbstractCollection
{
    /**
     * @var string $_idFieldName
     */
    protected $_idFieldName = Job::JOB_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Job::class, \Maxime\Jobs\Model\ResourceModel\Job::class);
    }
}
