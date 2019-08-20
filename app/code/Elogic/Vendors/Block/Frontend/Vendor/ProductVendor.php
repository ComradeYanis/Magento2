<?php

namespace Elogic\Vendors\Block\Frontend\Vendor;

use Elogic\Vendors\Api\Data\VendorInterface;
use Elogic\Vendors\Model\Vendor;
use Elogic\Vendors\Model\VendorRepository;
use Magento\Catalog\Model\Product;

use Magento\Framework\Exception\NoSuchEntityException;
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
     * ProductVendor constructor.
     * @param Context $context
     * @param Registry $registry
     * @param VendorRepository $vendorRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        VendorRepository $vendorRepository,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_vendorRepository = $vendorRepository;
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
     * @return VendorInterface
     * @throws NoSuchEntityException
     */
    public function getVendor()
    {
        $this->_product ?: $this->getProduct();

        $elogic_vendor_id = intval($this->_product->getElogicVendor());

        return $this->_vendorRepository->get($elogic_vendor_id);
    }
}
