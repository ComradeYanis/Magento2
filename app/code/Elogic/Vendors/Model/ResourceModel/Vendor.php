<?php

namespace Elogic\Vendors\Model\ResourceModel;

use Elogic\Vendors\Api\Data\VendorInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Vendor
 * @package Elogic\Vendors\Model\ResourceModel
 */
class Vendor extends AbstractDb
{

    /**
     * Elogic_Vendor table name
     * @const TABLE_NAME
     * @var string
     */
    const TABLE_NAME = 'elogic_vendor';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, VendorInterface::ENTITY_ID);
    }
}
