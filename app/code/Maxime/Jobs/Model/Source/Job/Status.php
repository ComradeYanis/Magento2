<?php

namespace Maxime\Jobs\Model\Source\Job;

use Magento\Framework\Data\OptionSourceInterface;
use Maxime\Jobs\Model\Job;

/**
 * Class Status
 * @package Maxime\Jobs\Model\Source\Job
 */
class Status implements OptionSourceInterface
{
    /**
     * @var Job $_job
     */
    protected $_job;

    /**
     * Constructor
     *
     * @param Job $job
     */
    public function __construct(Job $job)
    {
        $this->_job = $job;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->_job->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
