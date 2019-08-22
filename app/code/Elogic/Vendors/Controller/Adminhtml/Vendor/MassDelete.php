<?php

namespace Elogic\Vendors\Controller\Adminhtml\Vendor;

use Elogic\Vendors\Api\VendorRepositoryInterface;
use Elogic\Vendors\Model\ResourceModel\Vendor\CollectionFactory;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Ui\Component\MassAction\Filter;
use Psr\Log\LoggerInterface;

/**
 * Class MassDelete
 * @package Elogic\Vendors\Controller\Adminhtml\Vendor
 */
class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * @var Filter $filter
     */
    protected $filter;

    /**
     * @var CollectionFactory $collectionFactory
     */
    protected $collectionFactory;

    /**
     * @var File $_file
     */
    protected $_file;

    /**
     * @var VendorRepositoryInterface $_vendorRepository
     */
    protected $_vendorRepository;

    /**
     * @var LoggerInterface $_logger
     */
    protected $_logger;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param File $file
     * @param VendorRepositoryInterface $vendorRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        File $file,
        VendorRepositoryInterface $vendorRepository,
        LoggerInterface $logger
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_file = $file;
        $this->_vendorRepository = $vendorRepository;
        $this->_logger = $logger;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return Redirect
     * @throws LocalizedException|Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        $vendorDeleted = 0;
        $vendorDeletedError = 0;

        foreach ($collection->getItems() as $item) {
            try {
                $this->_vendorRepository->delete($item);
                $vendorDeleted++;
            } catch (LocalizedException $e) {
                $this->_logger->error($e->getLogMessage());
                $vendorDeletedError++;
            }
        }

        if ($vendorDeleted) {
            $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $vendorDeleted));
        }

        if ($vendorDeletedError) {
            $this->messageManager->addErrorMessage(
                __(
                    'A total of %1 record(s) haven\'t been deleted. Please see server logs for more details.',
                    $vendorDeletedError
                )
            );
        }

        /** @var Redirect $resultRedirect */
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
    }
}
