<?php

namespace Maxime\Jobs\Model\ResourceModel\Job;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Maxime\Jobs\Model\Department;
use Maxime\Jobs\Model\Job;

/**
 * Class Collection
 * @package Maxime\Jobs\Model\ResourceModel\Job
 */
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

    /**
     * @param Job $job
     * @param Department $department
     * @return Collection
     * @throws LocalizedException
     */
    public function addStatusFilter($job, $department)
    {
        $this->addFieldToSelect('*')
            ->addFieldToFilter('status', $job->getEnableStatus()) // AND
//            ->addFieldToFilter('status', ['eq' => $job->getEnableStatus()]) // AND
//        ->addFieldToFilter('date', ['qt' => date('Y-m-d')])     // AND
//        ->addFieldToFilter(['status,date'], ['eq' => $job->getEnableStatus(), 'qt' => date('Y-m-d')]) //OR

            ->getSelect()
            ->joinLeft(
                ['department' => $department->getResource()->getMainTable()],
                'main_table.department_id = department.' . $job->getIdFieldName(),
                ['department_name' => 'name']
            );

        return $this;
    }
}
