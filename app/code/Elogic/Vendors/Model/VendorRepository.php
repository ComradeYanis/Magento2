<?php

namespace Elogic\Vendors\Model;

use Elogic\Vendors\Api\Data\VendorInterface;
use Elogic\Vendors\Api\Data\VendorSearchResultInterface;
use Elogic\Vendors\Api\Data\VendorSearchResultInterfaceFactory;
use Elogic\Vendors\Api\VendorRepositoryInterface;
use Elogic\Vendors\Model\ResourceModel\Vendor as VendorResource;
use Elogic\Vendors\Model\ResourceModel\Vendor\Collection;
use Elogic\Vendors\Model\ResourceModel\Vendor\CollectionFactory;
use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File;

/**
 * Class VendorRepository
 * @package Elogic\Vendors\Model
 */
class VendorRepository implements VendorRepositoryInterface
{

    /**
     * @const BASE_MEDIA_PATH
     */
    const BASE_MEDIA_PATH = 'elogic/vendors/images';

    /**
     * @var array $registry
     */
    private $registry = [];

    /**
     * @var VendorResource $vendorResource
     */
    private $vendorResource;

    /**
     * @var VendorFactory $vendorFactory
     */
    private $vendorFactory;

    /**
     * @var CollectionFactory $vendorCollectionFactory
     */
    private $vendorCollectionFactory;

    /**
     * @var VendorSearchResultInterfaceFactory $vendorSearchResultInterfaceFactory
     */
    private $vendorSearchResultInterfaceFactory;

    /**
     * @var Filesystem $_fileSystem
     */
    private $_fileSystem;

    /**
     * VendorRepository constructor.
     * @param VendorResource $vendorResource
     * @param VendorFactory $vendorFactory
     * @param CollectionFactory $vendorCollectionFactory
     * @param VendorSearchResultInterfaceFactory $vendorSearchResultFactory
     * @param Filesystem $filesystem
     */
    public function __construct(
        VendorResource $vendorResource,
        VendorFactory $vendorFactory,
        CollectionFactory $vendorCollectionFactory,
        VendorSearchResultInterfaceFactory $vendorSearchResultFactory,
        Filesystem $filesystem
    ) {
        $this->vendorResource                       = $vendorResource;
        $this->vendorFactory                        = $vendorFactory;
        $this->vendorCollectionFactory              = $vendorCollectionFactory;
        $this->vendorSearchResultInterfaceFactory   = $vendorSearchResultFactory;
        $this->_fileSystem                          = $filesystem;
    }

    /**
     * @param int $id
     * @return VendorInterface
     * @throws NoSuchEntityException
     */
    public function get(int $id)
    {
        if (!array_key_exists($id, $this->registry)) {
            /** @var Vendor $vendor */
            $vendor = $this->vendorFactory->create();
            $vendor->load($id);
            if (!$vendor->getEntityId()) {
                throw new NoSuchEntityException(__('Requested vendor does not exist'));
            }
            $this->registry[$id] = $vendor;
        }

        return $this->registry[$id];
    }

    /**
     * @return Vendor
     */
    public function create()
    {
        return $this->vendorFactory->create();
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return VendorSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Collection $collection */
        $collection = $this->vendorCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        /** @var VendorSearchResultInterface $searchResult */
        $searchResult = $this->vendorSearchResultInterfaceFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        return $searchResult;
    }

    /**
     * @param VendorInterface $vendor
     * @return VendorInterface
     * @throws StateException
     */
    public function save(VendorInterface $vendor)
    {
        try {
            /** @var Vendor $vendor */
            $this->vendorResource->save($vendor);
            $this->registry[$vendor->getEntityId()] = $this->get($vendor->getEntityId());
        } catch (Exception $exception) {
            throw new StateException(__('Unable to save vendor #%1', $vendor->getEntityId()));
        }
        return $this->registry[$vendor->getEntityId()];
    }

    /**
     * @param VendorInterface $vendor
     * @return bool
     * @throws StateException
     */
    public function delete(VendorInterface $vendor)
    {
        try {
            /** @var Vendor $vendor */
            $logo = $vendor->getLogo();
            if (isset($logo) && strlen($logo)) {
                try {
                    $file = new File();
                    $mediaDirectory = $this->_fileSystem->getDirectoryRead(DirectoryList::MEDIA);
                    $mediaRootDir   = $mediaDirectory->getAbsolutePath();
                    $filePath = $mediaRootDir . $logo;
                    if ($file->isExists($filePath)) {
                        $file->deleteFile($filePath);
                    }
                } catch (Exception $e) {
                    throw new StateException(__('Unable to remove image for vendor #%1', $vendor->getEntityId()));
                }
            }
            $this->vendorResource->delete($vendor);
            unset($this->registry[$vendor->getEntityId()]);
        } catch (Exception $e) {
            throw new StateException(__('Unable to remove vendor #%1', $vendor->getEntityId()));
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws StateException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id)
    {
        return $this->delete($this->get($id));
    }
}
