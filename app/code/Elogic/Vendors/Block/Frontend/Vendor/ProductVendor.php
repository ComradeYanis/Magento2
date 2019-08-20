<?php

namespace Elogic\Vendors\Block\Frontend\Vendor;

use Elogic\Vendors\Api\Data\VendorInterface;
use Elogic\Vendors\Api\Data\VendorSearchResultInterface;
use Elogic\Vendors\Model\VendorRepository;
use Magento\Catalog\Model\Product;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class ProductVendor
 * @package Elogic\Vendors\Block\Frontend\Vendor
 */
class ProductVendor extends Template
{

    /**
     * @var Product $_product
     */
    protected $_product;

    /**
     * @var VendorRepository $_vendorRepository
     */
    protected $_vendorRepository;

    /**
     * @var Registry $_coreRegistry
     */
    protected $_coreRegistry;

    /**
     * @var VendorSearchResultInterface $_searchResult
     */
    protected $_searchResult;

    /**
     * ProductVendor constructor.
     * @param Context $context
     * @param Registry $registry
     * @param VendorRepository $vendorRepository
     * @param VendorSearchResultInterface $vendorSearchResult
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        VendorRepository $vendorRepository,
        VendorSearchResultInterface $vendorSearchResult,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_vendorRepository = $vendorRepository;
        $this->_searchResult = $vendorSearchResult;
        parent::__construct($context, $data);
    }

    /**
     * @return Product|mixed
     */
    public function getProduct()
    {
        if (!$this->_product) {
            $this->_product = $this->_coreRegistry->registry('product');
        }

        return $this->_product;
    }

    /**
     * @return VendorSearchResultInterface
     */
    public function getVendors()
    {
        $this->_product ?: $this->getProduct();

        $elogic_vendor_id = $this->_product->getElogicVendor();

        /** @var SearchCriteriaBuilder $searchCriteriaBuilder */
        $searchCriteriaBuilder = ObjectManager::getInstance()->create(SearchCriteriaBuilder::class);
        $searchCriteria = $searchCriteriaBuilder->addFilter(
            VendorInterface::ENTITY_ID,
            $elogic_vendor_id,
            'eq'
        )->create();

        return $this->_vendorRepository->getList($searchCriteria);
    }
}
