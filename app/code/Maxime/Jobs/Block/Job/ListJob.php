<?php

namespace Maxime\Jobs\Block\Job;

use Magento\Catalog\Block\Breadcrumbs;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Template;
use Maxime\Jobs\Model\Department;
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

    /**
     * @var Department $_department
     */
    protected $_department;

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    protected $_jobCollection = null;

    /**
     * ListJob constructor.
     * @param Job $job
     * @param Department $department
     * @param ResourceConnection $resource
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Job $job,
        Department $department,
        ResourceConnection $resource,
        Template\Context $context,
        array $data = []
    ) {
        $this->_job         = $job;
        $this->_department  = $department;
        $this->_resource    = $resource;

        parent::__construct($context, $data);
    }

    /**
     * @return Template|void
     * @throws LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $title          = __('We are hiring');
        $description    = __('Look at the jobs we have got for you');
        $keywords       = __('job,hiring');

        $this->getLayout()->createBlock(Breadcrumbs::class);

        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'jobs',
                [
                    'label' => $title,
                    'title' => $title,
                    'link'  => false // No link for the last element
                ]
            );
        }

        $this->pageConfig->getTitle()->set($title);
        $this->pageConfig->setDescription($description);
        $this->pageConfig->setKeywords($keywords);

        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');

        if ($pageMainTitle) {
            $pageMainTitle->setPageTitle($title);
        }

        return $this;
    }

    /**
     * @return |null
     * @throws LocalizedException
     */
    public function _getJobCollection()
    {
        if ($this->_jobCollection === null) {

            $jobCollection = $this->getCollection()
                ->addFieldToSelect('*')
                ->addFieldToFilter('status', $this->_job->getEnableStatus())
                ->join(
                    ['department' => $this->_department->getResource()->getMainTable()],
                    'main_table.department_id = department.' . $this->_job->getIdFieldName(),
                    ['department_name' => 'name']
                );

            $this->_jobCollection = $jobCollection;
        }

        return $this->_jobCollection;
    }

    /**
     * @return |null
     * @throws LocalizedException
     */
    public function getLoadedJobCollection()
    {
        return $this->_getJobCollection();
    }

    /**
     * @param $job
     * @return string
     */
    public function getJobUrl($job)
    {
        /** @var Job $job */
        return !$job->getId() ? '#' : $this->getUrl('jobs/department/view', ['id' => $job->getDepartmentId()]);
    }
}
