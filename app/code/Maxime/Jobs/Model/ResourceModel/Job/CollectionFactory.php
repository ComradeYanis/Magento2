<?php

namespace Maxime\Jobs\Model\ResourceModel\Job;

use Magento\Framework\ObjectManagerInterface;

/**
 * Class CollectionFactory
 * @package Maxime\Jobs\Model\ResourceModel\Job
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
    public function __construct(ObjectManagerInterface $objectManager, $instanceName = '\\Maxime\\Jobs\\Model\\ResourceModel\\Job\\Collection')
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
