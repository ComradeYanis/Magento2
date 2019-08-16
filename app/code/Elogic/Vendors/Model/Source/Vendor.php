<?php

namespace Elogic\Vendors\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class Vendor
 * @package Elogic\Vendors\Model\Source
 */
class Vendor extends AbstractSource
{
    /**
     * @var \Elogic\Vendors\Model\Vendor $_vendor
     */
    protected $_vendor;

    /**
     * Constructor
     *
     * @param \Elogic\Vendors\Model\Vendor $vendor
     */
    public function __construct(\Elogic\Vendors\Model\Vendor $vendor)
    {
        $this->_vendor = $vendor;
    }

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $options[] = ['label' => '', 'value' => ''];
        $vendorCollection = $this->_vendor->getCollection()
            ->addFieldToSelect('entity_id')
            ->addFieldToSelect('name');
        foreach ($vendorCollection as $vendor) {
            $options[] = [
                'label' => $vendor->getName(),
                'value' => $vendor->getId(),
            ];
        }
        return $options;
    }
}
