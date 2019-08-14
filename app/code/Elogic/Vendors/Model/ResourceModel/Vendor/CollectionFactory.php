<?php

namespace Elogic\Vendors\Model\ResourceModel\Vendor;

use Magento\Framework\ObjectManagerInterface;

/**
 * Class CollectionFactory
 * @package Elogic\Vendors\Model\ResourceModel\Vendor
 */
class CollectionFactory
{
    /**
     * Object Manager instance
     *
     * @var ObjectManagerInterface $_objectManager
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string $_instanceName
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(ObjectManagerInterface $objectManager, $instanceName = '\\Elogic\\Vendors\\Model\\ResourceModel\\Vendor\\Collection')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return Collection
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
