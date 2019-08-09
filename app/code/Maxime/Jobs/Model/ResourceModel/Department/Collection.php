<?php

namespace Maxime\Jobs\Model\ResourceModel\Department;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Maxime\Jobs\Model\Department;

class Collection extends AbstractCollection
{
    /**
     * @var string $_idFieldName
     */
    protected $_idFieldName = Department::DEPARTMENT_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Department::class, \Maxime\Jobs\Model\ResourceModel\Department::class);
    }
}
