<?php

namespace Elogic\Vendors\Controller\Adminhtml\Vendor;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Ui\Component\MassAction\Filter;
use Elogic\Vendors\Model\ResourceModel\Vendor\CollectionFactory;

/**
 * Class MassDelete
 * @package Elogic\Vendors\Controller\Adminhtml\Vendor
 */
class MassDelete extends Action
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
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param File $file
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        File $file
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_file = $file;
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
        $collectionSize = $collection->getSize();
        foreach ($collection as $item) {
            $logo = $item->getLogo();
            if (isset($logo) && strlen($logo)) {
                try {
                    $this->_file->deleteFile($logo);
                } catch (Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                }
            }
            $item->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
