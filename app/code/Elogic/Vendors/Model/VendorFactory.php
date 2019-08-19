<?php

namespace Elogic\Vendors\Model;

use Magento\Framework\ObjectManagerInterface;

/**
 * Class VendorFactory
 * @package Elogic\Vendors\Model
 */
class VendorFactory
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
    public function __construct(ObjectManagerInterface $objectManager, $instanceName = Vendor::class)
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return Vendor
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
