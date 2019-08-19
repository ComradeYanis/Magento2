<?php

namespace Elogic\Vendors\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface VendorSearchResultInterface
 * @package Elogic\Vendors\Api\Data
 */
interface VendorSearchResultInterface extends SearchResultsInterface
{

    /**
     * @return VendorInterface[]
     */
    public function getItems();

    /**
     * @param VendorInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
