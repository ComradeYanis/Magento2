<?php

namespace Elogic\Vendors\Block\Adminhtml\Vendor\Edit;

use Elogic\Vendors\Model\Vendor;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;

/**
 * Class Form
 * @package Elogic\Vendors\Block\Adminhtml\Vendor\Edit
 */
class Form extends Generic
{

    /**
     * @var Store $_systemStore
     */
    protected $_systemStore;

    /**
     * Form constructor.
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
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('vendor_form');
        $this->setTitle('Vendor Information');
    }

    /**
     * @return Generic
     * @throws LocalizedException
     */
    protected function _prepareForm()
    {
        /** @var Vendor $model */
        $model = $this->_coreRegistry->registry('vendors_vendor');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('vendor_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        }

        $fieldset->addField(
            'name',
            'text',
            ['name' => 'name', 'label' => __('Vendor Name'), 'title' => __('Vendor Name'), 'required' => true]
        );

        $fieldset->addField(
            'description',
            'textarea',
            ['name' => 'description', 'label' => __('Vendor Description'), 'title' => __('Vendor Description'), 'required' => true]
        );

        // Date - Type date
        if (!$model->getId()) {
            $model->setDate(date('Y-m-d')); // Day date when adding a job
        }
        $fieldset->addField(
            'date',
            'date',
            ['name' => 'date', 'label' => __('Date'), 'title' => __('Date'), 'required' => false, 'date_format' => 'Y-MM-dd']
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
