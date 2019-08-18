<?php

namespace Elogic\Vendors\Helper;

use Elogic\Vendors\Model\Vendor as ModelVendor;
use Magento\Catalog\Helper\Data;
use Magento\Eav\Model\Config;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filter\Template;

/**
 * Class FrontOutput
 * @package Elogic\Vendors\Helper
 */
class FrontOutput extends AbstractHelper
{
    /**
     * Array of existing handlers
     *
     * @var array
     */
    protected $_handlers;

    /**
     * Template processor instance
     *
     * @var Template
     */
    protected $_templateProcessor = null;

    /**
     * Catalog data
     *
     * @var Data
     */
    protected $_catalogData = null;

    /**
     * Eav config
     *
     * @var Config
     */
    protected $_eavConfig;

    /**
     * @var array
     */
    private $directivePatterns;

    /**
     * Output constructor.
     * @param Context $context
     * @param Config $eavConfig
     * @param Data $catalogData
     * @param array $directivePatterns
     */
    public function __construct(
        Context $context,
        Config $eavConfig,
        Data $catalogData,
        $directivePatterns = []
    ) {
        $this->_eavConfig = $eavConfig;
        $this->_catalogData = $catalogData;
        $this->directivePatterns = $directivePatterns;
        parent::__construct($context);
    }

    /**
     * @return Template
     * @throws LocalizedException
     */
    protected function _getTemplateProcessor()
    {
        if (null === $this->_templateProcessor) {
            $this->_templateProcessor = $this->_catalogData->getPageTemplateProcessor();
        }

        return $this->_templateProcessor;
    }

    /**
     * Adding method handler
     *
     * @param string $method
     * @param object $handler
     * @return $this
     */
    public function addHandler($method, $handler)
    {
        if (!is_object($handler)) {
            return $this;
        }
        $method = strtolower($method);

        if (!isset($this->_handlers[$method])) {
            $this->_handlers[$method] = [];
        }

        $this->_handlers[$method][] = $handler;
        return $this;
    }

    /**
     * Get all handlers for some method
     *
     * @param string $method
     * @return array
     */
    public function getHandlers($method)
    {
        $method = strtolower($method);
        return $this->_handlers[$method] ?? [];
    }

    /**
     * Process all method handlers
     *
     * @param string $method
     * @param mixed $result
     * @param array $params
     * @return mixed
     */
    public function process($method, $result, $params)
    {
        foreach ($this->getHandlers($method) as $handler) {
            if (method_exists($handler, $method)) {
                $result = $handler->{$method}($this, $result, $params);
            }
        }
        return $result;
    }

    /**
     * Prepare vendor attribute html output
     *
     * @param ModelVendor $vendor
     * @param string $attributeHtml
     * @param string $attributeName
     * @return string
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @throws LocalizedException
     */
    public function vendorAttribute($vendor, $attributeHtml, $attributeName)
    {
        $attribute = $this->_eavConfig->getAttribute(ModelVendor::ENTITY, $attributeName);
        if ($attribute && $attribute->getId() && $attribute->getFrontendInput() != 'logo') {
            if ($attribute->getFrontendInput() == 'description') {
                $attributeHtml = nl2br($attributeHtml);
            }
        }
        if ($attributeHtml !== null && $this->isDirectivesExists($attributeHtml)) {
            $attributeHtml = $this->_getTemplateProcessor()->filter($attributeHtml);
        }

        $attributeHtml = $this->process(
            'vendorAttribute',
            $attributeHtml,
            ['vendor' => $vendor, 'attribute' => $attributeName]
        );

        return $attributeHtml;
    }

    /**
     * Check if string has directives
     *
     * @param string $attributeHtml
     * @return bool
     */
    public function isDirectivesExists($attributeHtml)
    {
        $matches = false;
        foreach ($this->directivePatterns as $pattern) {
            if (preg_match($pattern, $attributeHtml)) {
                $matches = true;
                break;
            }
        }
        return $matches;
    }
}
