<?php

namespace Elogic\Vendors\Model;

use Elogic\Vendors\Api\Data\VendorInterface;
use Elogic\Vendors\Model\ResourceModel\Vendor as VendorResource;
use Elogic\Vendors\Model\VendorFactory;
use Magento\Catalog\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

/**
 * Class Vendor
 * @package Elogic\Vendors\Model
 */
class Vendor extends AbstractModel implements VendorInterface
{

    /**
     * Elogic_Vendor table name
     * @const TABLE_NAME
     */
    const TABLE_NAME = 'elogic_vendor';

    /**
     * @var string $_idFieldName
     */
    protected $_idFieldName = VendorInterface::ENTITY_ID;

    /**
     * @var VendorFactory $vendorFactory
     */
    private $vendorFactory;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(VendorResource::class);
    }

    /**
     * Vendor constructor.
     * @param \Elogic\Vendors\Model\VendorFactory $vendorFactory
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        VendorFactory $vendorFactory,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->vendorFactory = $vendorFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @return string
     */
    public function getLogoUrl()
    {
//        return $this->_store_manager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $this->getLogo();
        return '';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData(VendorInterface::NAME);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->setData(VendorInterface::NAME, $name);
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->getData(VendorInterface::DESCRIPTION);
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->setData(VendorInterface::DESCRIPTION, $description);
        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->getData(VendorInterface::DATE);
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setDate(string $date)
    {
        $this->setData(VendorInterface::DATE, $date);
        return $this;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->getData(VendorInterface::LOGO);
    }

    /**
     * @param string $logo
     * @return $this
     */
    public function setLogo(string $logo)
    {
        $this->setData(VendorInterface::LOGO, $logo);
        return $this;
    }
}
