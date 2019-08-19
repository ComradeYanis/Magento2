<?php

namespace Elogic\Vendors\Model\ResourceModel\Vendor;

use Elogic\Vendors\Model\Vendor;
use \Elogic\Vendors\Model\ResourceModel\Vendor as VendorResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Elogic\Vendors\Model\ResourceModel\Vendor
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Vendor::class, VendorResource::class);
    }
}
