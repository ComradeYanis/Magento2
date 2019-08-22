<?php

namespace Elogic\Vendors\Helper;

use Exception;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class UploadPhoto
 * @package Elogic\Vendors\Helper
 */
class UploadPhoto
{
    /**
     * @var StoreManagerInterface $_storeManager
     */
    protected $_storeManager;

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
     * UploadPhoto constructor.
     * @param StoreManagerInterface $storeManager
     * @param UploaderFactory $uploader
     * @param AdapterFactory $adapterFactory
     * @param Filesystem $filesystem
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        UploaderFactory $uploader,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem
    ) {
        $this->_storeManager    = $storeManager;
        $this->_uploader        = $uploader;
        $this->_adapterFactory  = $adapterFactory;
        $this->_fileSystem      = $filesystem;
    }

    /**
     * @param array $data
     * @param string $photoAttributeName
     * @param array $requestFile
     * @param string $mediaPath
     * @param string $fileDirectory
     * @return mixed|string
     * @throws NoSuchEntityException
     */
    public function uploadPhoto(array $data, string $photoAttributeName, array $requestFile, string $mediaPath, string $fileDirectory = DirectoryList::MEDIA)
    {
        if (isset($requestFile) && isset($requestFile['name']) && strlen($requestFile['name'])) {
            try {
                $uploader = $this->_uploader->create(['fileId' => $photoAttributeName]);
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $imageAdapter = $this->_adapterFactory->create();

                $uploader->addValidateCallback('logo', $imageAdapter, 'validateUploadFile');
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);

                $result = $uploader->save($this->getMediaPath($fileDirectory)->getAbsolutePath($mediaPath));

                $result = $mediaPath . $result['file'];
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        } else {
            if (isset($data['logo']) && isset($data['logo']['value'])) {
                if (isset($data['logo']['delete'])) {
                    $data['logo'] = null;
                    $data['delete_logo'] = true;
                    $fullFilePath = $this->getMediaPath($fileDirectory)->getAbsolutePath($data['logo']['value'])
                    if ($this->_file->isExists($fullFilePath)) {
                        try {
                            $this->_file->deleteFile($fullFilePath);
                        } catch (Exception $e) {
                            throw new Exception($e->getMessage());
                        }
                    }
                } elseif (isset($data['logo']['value'])) {
                    $result = $data['logo']['value'];
                }
            }
        }

        return $result;
    }

    /**
     * @param string $baseFilePath
     * @return Filesystem\Directory\ReadInterface
     */
    protected function getMediaPath(string $baseFilePath)
    {
        return $this->_fileSystem->getDirectoryRead($baseFilePath);
    }}
