<?php

namespace Maxime\Jobs\Block\Adminhtml\Job\Edit;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
use Maxime\Jobs\Model\Job;
use Maxime\Jobs\Model\Source\Department;
use Maxime\Jobs\Model\Source\Job\Status;

/**
 * Class Form
 * @package Maxime\Jobs\Block\Adminhtml\Job\Edit
 */
class Form extends Generic
{
    /**
     * @var Store $_systemStore
     */
    protected $_systemStore;

    /**
     * @var Store $_status
     */
    protected $_status;

    /**
     * @var Store $_department
     */
    protected $_department;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Store $systemStore
     * @param Department $department
     * @param Status $status
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Store $systemStore,
        Department $department,
        Status $status,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_department = $department;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('job_form');
        $this->setTitle(__('Job Information'));
    }

    /**
     * Prepare form
     *
     * @return Generic
     * @throws LocalizedException
     */
    protected function _prepareForm()
    {
        /** @var Job $model */
        $model = $this->_coreRegistry->registry('jobs_job');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('job_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            ['name' => 'title', 'label' => __('Title'), 'title' => __('Title'), 'required' => true]
        );

        $fieldset->addField(
            'type',
            'text',
            ['name' => 'title', 'label' => __('Type'), 'title' => __('Type'), 'required' => true]
        );

        if (!$model->getId()) {
            $model->setDate(date('Y-m-d'));
        }
        $fieldset->addField(
            'location',
            'text',
            ['name' => 'location', 'label' => __('Location'), 'title' => __('Location'), 'required' => true]
        );

        $fieldset->addField(
            'date',
            'date',
            ['name' => 'date', 'label' => __('Date'), 'title' => __('Date'), 'required' => false, 'date_format' => 'Y-mm-dd']
        );

        $statuses = $this->_status->toOptionArray();
        $fieldset->addField(
            'status',
            'select',
            ['name' => 'status', 'label' => __('Status'), 'title' => __('Status'), 'required' => true, 'values' => $statuses]
        );

        $fieldset->addField(
            'description',
            'textarea',
            ['name' => 'description', 'label' => __('Description'), 'title' => __('Description'), 'required' => true]
        );

        $departments = $this->_department->toOptionArray();
        $fieldset->addField(
            'department_id',
            'select',
            ['name' => 'department_id', 'label' => __('Department'), 'title' => __('Department'), 'required' => true, 'valuse' => $departments]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
