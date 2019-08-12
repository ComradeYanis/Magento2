<?php

namespace Maxime\Jobs\Block\Adminhtml\Job\Edit;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
use Maxime\Jobs\Model\Job;

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
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param Store $systemStore
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
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

        $fieldset->addField(
            'location',
            'text',
            ['name' => 'location', 'label' => __('Location'), 'title' => __('Location'), 'required' => true]
        );

        $fieldset->addField(
            'date',
            'text',
            ['name' => 'date', 'label' => __('Date'), 'title' => __('Date'), 'required' => false]
        );

        $fieldset->addField(
            'status',
            'text',
            ['name' => 'status', 'label' => __('Status'), 'title' => __('Status'), 'required' => true]
        );

        $fieldset->addField(
            'description',
            'textarea',
            ['name' => 'description', 'label' => __('Description'), 'title' => __('Description'), 'required' => true]
        );

        $fieldset->addField(
            'department_id',
            'text',
            ['name' => 'department_id', 'label' => __('Department'), 'title' => __('Department'), 'required' => true]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
