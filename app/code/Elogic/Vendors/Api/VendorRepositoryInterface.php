<?php

namespace Elogic\Vendors\Api;

use Elogic\Vendors\Api\Data\VendorInterface;
use Elogic\Vendors\Api\Data\VendorSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface VendorRepositoryInterface
 * @package Elogic\Vendors\Api
 */
interface VendorRepositoryInterface
{
    /**
     * @param int $id
     * @return VendorInterface
     */
    public function get(int $id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return VendorSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param VendorInterface $post
     * @return VendorInterface
     */
    public function save(VendorInterface $post);

    /**
     * @param VendorInterface $post
     * @return bool
     */
    public function delete(VendorInterface $post);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id);
}
