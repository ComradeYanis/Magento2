<?php

namespace Elogic\Vendors\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Vendor
 * @package Elogic\Vendors\Model
 */
class Vendor extends AbstractModel
{

    /**
     * @const VENDOR_ID
     */
    const VENDOR_ID = 'entity_id';

    /**
     * @var string $_eventPrefix
     */
    protected $_eventPrefix = 'vendors';

    /**
     * @var string $_eventObject
     */
    protected $_eventObject = 'vendor';

    /**
     * @var string $_idFieldName
     */
    protected $_idFieldName = self::VENDOR_ID;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Vendor::class);
    }
}
