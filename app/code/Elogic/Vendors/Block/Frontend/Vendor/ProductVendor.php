<?php

namespace Elogic\Vendors\Block\Frontend\Vendor;

use Elogic\Vendors\Model\Vendor;
use Magento\Catalog\Model\Product;

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
     * @var Vendor $_vendor
     */
    protected $_vendor;

    /**
     * @var Registry $_coreRegistry
     */
    protected $_coreRegistry;

    /**
     * ProductVendor constructor.
     * @param Context $context
     * @param Registry $registry
     * @param Vendor $vendor
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Vendor $vendor,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_vendor = $vendor;
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
     * @return Vendor
     */
    public function getVendor()
    {
        $this->_product ?: $this->getProduct();

        $this->_vendor->load($this->_product->getElogicVendor());

        return $this->_vendor;
    }
}
