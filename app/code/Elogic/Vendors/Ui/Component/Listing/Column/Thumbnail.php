<?php

namespace Elogic\Vendors\Ui\Component\Listing\Column;

use Magento\Catalog\Helper\Image;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Thumbnail
 * @package Elogic\Vendors\Ui\Component\Listing\Column
 */
class Thumbnail extends Column
{

    /**
     * @const ALT_FIELD
     */
    const ALT_FIELD = 'name';

    /**
     * @var StoreManagerInterface $_storeManager
     */
    protected $_storeManager;

    /**
     * @var Image $_imageHelper
     */
    protected $_imageHelper;

    /**
     * @var UrlInterface $_urlBuilder
     */
    protected $_urlBuilder;

    /**
     * Thumbnail constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Image $image
     * @param UrlInterface $urlBuilder
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Image $image,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        $this->_storeManager    = $storeManager;
        $this->_imageHelper     = $image;
        $this->_urlBuilder      = $urlBuilder;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     * @throws NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $url = '';
                if ($item[$fieldName] != '') {
                    $url = $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $item[$fieldName];
                }
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = $this->getAlt($item) ?: '';
                $item[$fieldName . '_link'] = $this->_urlBuilder->getUrl(
                    'vendors/vendor/edit',
                    ['id' => $item['entity_id']]
                );
                $item[$fieldName . '_orig_src'] = $url;
            }
        }

        return $dataSource;
    }

    /**
     * @param $row
     * @return string|null
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}
