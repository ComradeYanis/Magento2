<?php

namespace Maxime\Jobs\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Department
 * @package Maxime\Jobs\Model
 */
class Department extends AbstractModel
{
    /**
     * @const DEPARTMENT_ID
     */
    const DEPARTMENT_ID = 'entity_id';

    /**
     * Prefix of model events names
     *
     * @var string $_eventPrefix
     */
    protected $_eventPrefix = 'jobs';

    /**
     * Name of event object
     *
     * @var string $_eventObject
     */
    protected $_eventObject = 'department';

    /**
     * Name of object id field
     *
     * @var string $_idFieldName
     */
    protected $_idFieldName = self::DEPARTMENT_ID;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Department::class);
    }
}
