<?php

namespace Elogic\Vendors\Block\Frontend\Vendor;

use Elogic\Vendors\Api\Data\VendorInterface;
use Elogic\Vendors\Api\Data\VendorSearchResultInterface;
use Elogic\Vendors\Model\VendorRepository;
use Magento\Catalog\Model\Product;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class ProductVendorName
 * @package Elogic\Vendors\Block\Frontend\Vendor
 */
class ProductVendorName implements ArgumentInterface
{

    /**
     * @var SearchCriteriaBuilder $_searchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var VendorRepository $_vendorRepository
     */
    protected $_vendorRepository;

    /**
     * ProductVendorName constructor.
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param VendorRepository $vendorRepository
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        VendorRepository    $vendorRepository
    ) {
        $this->_searchCriteriaBuilder   = $searchCriteriaBuilder;
        $this->_vendorRepository        = $vendorRepository;
    }

    /**
     * @param Product $product
     * @return VendorSearchResultInterface
     */
    public function getVendorsNames(Product $product)
    {
        $elogicVendorId = $product->getElogicVendor();

        $searchCriteria = $this->_searchCriteriaBuilder->addFilter(
            VendorInterface::ENTITY_ID,
            $elogicVendorId
        )->create();

        return $this->_vendorRepository->getList($searchCriteria);
    }
}
