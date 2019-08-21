<?php

namespace Elogic\Vendors\Controller\Adminhtml\Vendor;

use Elogic\Vendors\Model\Vendor;
use Elogic\Vendors\Model\VendorRepository;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem\Driver\File;
use Psr\Log\LoggerInterface;

/**
 * Class Delete
 * @package Elogic\Vendors\Controller\Adminhtml\Vendor
 */
class Delete extends Action
{

    /**
     * @var Vendor $_modelRepository
     */
    protected $_modelRepository;

    /**
     * @var File $_file
     */
    protected $_file;

    /**
     * @var LoggerInterface $_logger
     */
    protected $_logger;

    /**
     * @param Action\Context $context
     * @param VendorRepository $modelRepository
     * @param File $file
     * @param LoggerInterface $logger
     */
    public function __construct(
        Action\Context $context,
        VendorRepository $modelRepository,
        File $file,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->_modelRepository = $modelRepository;
        $this->_file            = $file;
        $this->_logger          = $logger;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Elogic_Vendors::vendor_delete');
    }

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $this->_modelRepository->deleteById($id);

                $this->messageManager->addSuccess(__('Vendor deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->_logger->error($e->getLogMessage());
                $this->messageManager->addErrorMessage(
                    __(
                        'The vendor #%1  haven\'t been deleted. Please see server logs for more details.',
                            $id
                        )
                );
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            } catch (Exception $e) {

                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('Vendor does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}
