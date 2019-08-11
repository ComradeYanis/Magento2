<?php

namespace Maxime\Jobs\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Department
 * @package Maxime\Jobs\Model\Source
 */
class Department implements OptionSourceInterface
{
    /**
     * @var \Maxime\Jobs\Model\Department $_department
     */
    protected $_department;

    /**
     * Constructor
     *
     * @param \Maxime\Jobs\Model\Department $department
     */
    public function __construct(\Maxime\Jobs\Model\Department $department)
    {
        $this->_department = $department;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $departmentCollection = $this->_department->getCollection()
            ->addFieldToSelect('entity_id')
            ->addFieldToSelect('name');
        foreach ($departmentCollection as $department) {
            $options[] = [
                'label' => $department->getName(),
                'value' => $department->getId(),
            ];
        }
        return $options;
    }
}
