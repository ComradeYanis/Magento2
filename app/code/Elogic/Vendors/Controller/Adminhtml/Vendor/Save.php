<?php

namespace Elogic\Vendors\Controller\Adminhtml\Vendor;

use Elogic\Vendors\Model\Vendor;
use Exception;
use File;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use RuntimeException;

/**
 * Class Save
 * @package Elogic\Vendors\Controller\Adminhtml\Vendor
 */
class Save extends Action
{
    /**
     * @var Vendor $_model
     */
    protected $_model;

    /**
     * @var UploaderFactory $_uploader
     */
    protected $_uploader;

    /**
     * @var AdapterFactory $_adapterFactory
     */
    protected $_adapterFactory;

    /**
     * @var Filesystem $_fileSystem
     */
    protected $_fileSystem;

    /**
     * @var Filesystem\Driver\File $_file
     */
    protected $_file;

    /**
     * @param Action\Context $context
     * @param Vendor $model
     * @param UploaderFactory $uploader
     * @param AdapterFactory $adapterFactory
     * @param Filesystem $filesystem
     * @param Filesystem\Driver\File $file
     */
    public function __construct(
        Action\Context $context,
        Vendor $model,
        UploaderFactory $uploader,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        Filesystem\Driver\File $file
    ) {
        $this->_uploader        = $uploader;
        $this->_adapterFactory  = $adapterFactory;
        $this->_fileSystem      = $filesystem;
        $this->_model           = $model;
        $this->_file            = $file;
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
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var Vendor $model */
            $model = $this->_model;

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }

            $file = $this->_request->getFiles('logo');
            if (isset($file) && isset($file['name']) && strlen($file['name'])) {
                try {
                    $base_media_path = 'elogic/vendors/images';
                    $uploader = $this->_uploader->create(['fileId' => 'logo']);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $imageAdapter = $this->_adapterFactory->create();

                    $uploader->addValidateCallback('logo', $imageAdapter, 'validateUploadFile');
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);

                    $mediaDirectory = $this->_fileSystem->getDirectoryRead(DirectoryList::MEDIA);
                    $result = $uploader->save($mediaDirectory->getAbsolutePath($base_media_path));

                    $data['logo'] = $base_media_path . $result['file'];
                } catch (Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                }
            } else {
                if (isset($data['logo']) && isset($data['logo']['value'])) {
                    if (isset($data['logo']['delete'])) {
                        $data['logo']           = null;
                        $data['delete_logo']    = true;
                        if ($this->_file->isExists($data['logo']['value'])) {
                            try {
                                $this->_file->deleteFile($data['logo']['value']);
                            } catch (Exception $e) {
                                $this->messageManager->addError($e->getMessage());
                            }
                        }
                    } elseif (isset($data['logo']['value'])) {
                        $data['logo'] = $data['logo']['value'];
                    } else {
                        $data['logo'] = null;
                    }
                }
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'vendors_vendor_prepare_save',
                ['vendor' => $model, 'request' => $this->getRequest()]
            );

            try {
                $model->save();
                $this->messageManager->addSuccess(__('Vendor saved'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
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
