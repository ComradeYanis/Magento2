<?php

namespace Elogic\Vendors\Block\Frontend\Vendor;

use Elogic\Vendors\Api\Data\VendorInterface;
use Elogic\Vendors\Api\Data\VendorSearchResultInterface;
use Elogic\Vendors\Model\VendorRepository;
use Magento\Catalog\Model\Product;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class ProductVendor
 * @package Elogic\Vendors\Block\Frontend\Vendor
 */
class ProductVendor implements ArgumentInterface
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
     * @var SearchCriteriaBuilder $_searchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * ProductVendor constructor.
     * @param Registry $registry
     * @param VendorRepository $vendorRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Registry $registry,
        VendorRepository $vendorRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->_coreRegistry            = $registry;
        $this->_vendorRepository        = $vendorRepository;
        $this->_searchCriteriaBuilder   = $searchCriteriaBuilder;
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
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->_product = $product;
    }

    /**
     * @return VendorSearchResultInterface
     */
    public function getVendors()
    {
        $this->_product ?: $this->getProduct();

        $elogicVendorIds = explode(',', $this->_product->getElogicVendor());

        $searchCriteria = $this->_searchCriteriaBuilder->addFilter(
            VendorInterface::ENTITY_ID,
            $elogicVendorIds,
            'in'
        )->create();

        return $this->_vendorRepository->getList($searchCriteria);
    }
}
