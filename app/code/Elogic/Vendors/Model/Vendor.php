<?php

namespace Elogic\Vendors\Model;

use Magento\Catalog\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Vendor
 * @package Elogic\Vendors\Model
 */
class Vendor extends AbstractModel
{

    /**
     * @const VENDOR_ID
     */
    public const VENDOR_ID = 'entity_id';

    /**
     * @const ENTITY
     */
    public const ENTITY = 'elogic_vendor';

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
     * @var StoreManagerInterface $_store_manager
     */
    protected $_store_manager;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(
    ) {
        $this->_init(ResourceModel\Vendor::class);
    }

    /**
     * Vendor constructor.
     * @param Context $context
     * @param Registry $registry
     * @param StoreManagerInterface $storeManager
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_store_manager = $storeManager;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Get attribute text by its code
     *
     * @param string $attributeCode Code of the attribute
     * @return string|array|null
     */
    public function getAttributeText($attributeCode)
    {
        return $this->getResource()->getAttribute($attributeCode)->getSource()->getOptionText(
            $this->getData($attributeCode)
        );
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getLogoUrl()
    {
        return $this->_store_manager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $this->getLogo();
    }
}
