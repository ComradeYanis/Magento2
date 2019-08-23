<?php

namespace Elogic\Vendors\Controller\Adminhtml\Vendor;

use Elogic\Vendors\Helper\UploadPhoto;
use Elogic\Vendors\Model\VendorRepository;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use RuntimeException;

/**
 * Class Save
 * @package Elogic\Vendors\Controller\Adminhtml\Vendor
 */
class Save extends Action
{

    //region PROTECTED_VARIABLES
    /**
     * @var VendorRepository $_modelRepository
     */
    protected $_modelRepository;

    /**
     * @var StoreManagerInterface $_storeManager
     */
    protected $_storeManager;

    /**
     * @var UploadPhoto $_uploadPhotoHelper
     */
    protected $_uploadPhotoHelper;

    //endregion

    /**
     * @param Action\Context $context
     * @param VendorRepository $modelRepository
     * @param UploadPhoto $uploadPhotoHelper
     */
    public function __construct(
        Action\Context $context,
        VendorRepository $modelRepository,
        UploadPhoto $uploadPhotoHelper
    ) {
        $this->_modelRepository = $modelRepository;
        $this->_uploadPhotoHelper = $uploadPhotoHelper;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Elogic_Vendors::vendor_save');
    }

    /**
     * Save action
     *
     * @return ResultInterface
     * @throws FileSystemException
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model = $this->_modelRepository->get($id);
            } else {
                $model = $this->_modelRepository->create();
            }

            $file = $this->_request->getFiles('logo');
            if (isset($file) && isset($file['name']) && strlen($file['name'])) {

                $data['logo'] = $this->_uploadPhotoHelper
                    ->uploadPhoto($data, 'logo', $file, $this->_modelRepository::BASE_MEDIA_PATH);
            }

            $this->_eventManager->dispatch(
                'vendors_vendor_prepare_save',
                ['vendor' => $model, 'request' => $this->getRequest()]
            );

            $model->setData($data);

            try {
                $this->_modelRepository->save($model);
                $this->messageManager->addSuccess(__('Vendor saved'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getEntityId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the vendor'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
