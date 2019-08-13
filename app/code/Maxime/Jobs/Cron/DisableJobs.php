<?php

namespace Maxime\Jobs\Cron;

use Exception;
use Magento\Cron\Model\Schedule;
use Maxime\Jobs\Model\Job;

/**
 * Class DisableJobs
 * @package Maxime\Jobs\Cron
 */
class DisableJobs
{

    /**
     * @var Job $job
     */
    protected $job;

    /**
     * DisableJobs constructor.
     * @param Job $job
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * @param Schedule $schedule
     * @throws Exception
     */
    public function execute(Schedule $schedule)
    {
        $nowDate = date('Y-m-d');
        $jobsCollection = $this->job->getCollection()
            ->addFieldToFilter('date', ['lt' => $nowDate]);

        /** @var Job $job */
        foreach ($jobsCollection as $job) {
            $job->setStatus($job->getDisableStatus());
            $job->save();
        }
    }
}
