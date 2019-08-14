<?php

namespace Elogic\Vendors\Block\Adminhtml\Vendor;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;

/**
 * Class Edit
 * @package Elogic\Vendors\Block\Adminhtml\Vendor
 */
class Edit extends Container
{

    /**
     * @var Registry $_coreRegistry
     */
    protected $_coreRegistry = null;

    /**
     * Edit constructor.
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Department edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId    = 'entity_id';
        $this->_blockGroup  = 'Elogic_Vendors';
        $this->_controller  = 'adminhtml_vendor';

        parent::_construct();

        if ($this->_isAllowedAction('Elogic_Vendors::vendor_save')) {
            $this->buttonList->update('save', 'label', __('Save Vendor'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ]
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }
    }

    /**
     * @return Phrase|string
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('vendors_vendor')->getId()) {
            return __("Edit Vendor '%1'", $this->escapeHtml($this->_coreRegistry->registry('vendors_vendor')->getName()));
        } else {
            return __('New Vendor');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('vendors/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}
