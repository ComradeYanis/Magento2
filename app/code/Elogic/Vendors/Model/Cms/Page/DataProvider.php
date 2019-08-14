<?php

namespace Elogic\Vendors\Model\Cms\Page;

use Magento\Cms\Model\Page;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\UrlInterface;

/**
 * Class DataProvider
 * @package Elogic\Vendors\Model\Cms\Page
 */
class DataProvider extends Page\DataProvider
{

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        /** @var $page Page */
        foreach ($items as $page) {
            $this->loadedData[$page->getId()] = $page->getData();
        }

        $data = $this->dataPersistor->get('cms_page');

        if (!empty($data)) {
            $page = $this->collection->getNewEmptyItem();

            $page->setData($data);
            $this->loadedData[$page->getId()] = $page->getData();
            $this->dataPersistor->clear('cms_page');
        }
        /* For Modify  You custom image field data */
        if (!empty($this->loadedData[$page->getId()]['logo'])) {
            $objectManager = ObjectManager::getInstance();
            $storeManager = $objectManager->get(Magento\Store\Model\StoreManagerInterface);
            $currentStore = $storeManager->getStore();
            $media_url=$currentStore->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

            $image_name=$this->loadedData[$page->getId()]['logo'];
            unset($this->loadedData[$page->getId()]['logo']);
            $this->loadedData[$page->getId()]['logo'][0]['name']=$image_name;
            $this->loadedData[$page->getId()]['logo'][0]['url']=$media_url . "cms/hero/tmp/" . $image_name;
        }
        return $this->loadedData;
    }
}
