<?php

namespace Elogic\Vendors\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Vendor
 * @package Elogic\Vendors\Model\ResourceModel
 */
class Vendor extends AbstractDb
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('elogic_vendor', 'entity_id');
    }
}
