<?php

namespace Elogic\Vendors\Model\ResourceModel\Vendor;

use Elogic\Vendors\Model\Vendor;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Elogic\Vendors\Model\ResourceModel\Vendor
 */
class Collection extends AbstractCollection
{
    /**
     * @var string $_idFieldName
     */
    protected $_idFieldName = Vendor::VENDOR_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Vendor::class, \Elogic\Vendors\Model\ResourceModel\Vendor::class);
    }

    /**
     * @param Vendor $vendor
     * @return Collection
     */
    public function addStatusFilter($vendor)
    {
        $this->addFieldToSelect('*')
//            ->addFieldToFilter('status', $vendor->getEnableStatus()) // AND
//            ->addFieldToFilter('status', ['eq' => $job->getEnableStatus()]) // AND
//        ->addFieldToFilter('date', ['qt' => date('Y-m-d')])     // AND
//        ->addFieldToFilter(['status,date'], ['eq' => $job->getEnableStatus(), 'qt' => date('Y-m-d')]) //OR

            ->getSelect()
            /*->joinLeft(
                ['department' => $department->getResource()->getMainTable()],
                'main_table.department_id = department.' . $job->getIdFieldName(),
                ['department_name' => 'name']
            )*/;

        return $this;
    }
}
