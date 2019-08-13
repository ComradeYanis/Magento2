<?php

namespace Maxime\Jobs\Block\Job;

use Magento\Catalog\Block\Breadcrumbs;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Maxime\Jobs\Model\Department;
use Maxime\Jobs\Model\Job;

/**
 * Class View
 * @package Maxime\Jobs\Block\Job
 */
class View extends Template
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
     * ListJob constructor.
     * @param Job $job
     * @param Department $department
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Job $job,
        Department $department,
        Template\Context $context,
        array $data = []
    ) {
        $this->_job         = $job;
        $this->_department  = $department;

        parent::__construct($context, $data);
    }

    /**
     * @return Template|void
     * @throws LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $job            = $this->getLoadedJob();
        $department     = $this->getLoadedDepartment();

        $title          = $job->getTitle() . ' - ' . $department->getName();
        $description    = __('Look at the jobs we have got for you');
        $keywords       = __('job,hiring');

        $this->getLayout()->createBlock(Breadcrumbs::class);

        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'jobs',
                [
                    'label' => __('We are hiring'),
                    'title' => __('We are hiring'),
                    'link'  => $this->getListJobUrl()
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'job',
                [
                    'label' => $department->getName(),
                    'title' => $department->getName(),
                    'link'  => $this->getDepartmentUrl($job)
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'job',
                [
                    'label' => $title,
                    'title' => $title,
                    'link'  => false
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
     * @return Job
     */
    public function _getJob()
    {
        if (!$this->_job->getId()) {
            $entityId   = $this->_request->getParam('id');
            $this->_job = $this->_job->load($entityId);
        }

        return $this->_job;
    }

    /**
     * @return Job
     */
    public function getLoadedJob()
    {
        return $this->_getJob();
    }

    /**
     * @return Department
     */
    public function _getDepartment()
    {
        if (!$this->_department->getId()) {
            $job = $this->getLoadedJob();
            $this->_department->load($job->getDepartmentId());
        }

        return $this->_department;
    }

    /**
     * @return Department
     */
    public function getLoadedDepartment()
    {
        return $this->_getDepartment();
    }

    /**
     * @return string
     */
    public function getListJobUrl()
    {
        return $this->getUrl('jobs/job');
    }

    /**
     * @param $job
     * @return string
     */
    public function getDepartmentUrl($job)
    {
        /** @var Job $job */
        return !$job->getDepartmentId() ? '#' : $this->getUrl('jobs/department/view', ['id' => $job->getDepartmentId()]);
    }
}
