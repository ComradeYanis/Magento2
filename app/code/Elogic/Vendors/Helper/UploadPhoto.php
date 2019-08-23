<?php

namespace Elogic\Vendors\Helper;

use Exception;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
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
     * @var Filesystem\Driver\File $_file
     */
    protected $_file;

    /**
     * UploadPhoto constructor.
     * @param StoreManagerInterface $storeManager
     * @param UploaderFactory $uploader
     * @param AdapterFactory $adapterFactory
     * @param Filesystem $filesystem
     * @param Filesystem\Driver\File $file
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        UploaderFactory $uploader,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        Filesystem\Driver\File $file
    ) {
        $this->_storeManager    = $storeManager;
        $this->_uploader        = $uploader;
        $this->_adapterFactory  = $adapterFactory;
        $this->_fileSystem      = $filesystem;
        $this->_file            = $file;
    }

    /**
     * @param array $data
     * @param string $photoAttributeName
     * @param array $requestFile
     * @param string $mediaPath
     * @param string $fileDirectory
     * @return mixed|string
     * @throws FileSystemException
     * @throws Exception
     */
    public function uploadPhoto(array $data, string $photoAttributeName, array $requestFile, string $mediaPath, string $fileDirectory = DirectoryList::MEDIA)
    {
        $result = null;

        if (isset($requestFile) && isset($requestFile['name']) && strlen($requestFile['name'])) {
            try {
                $result = $this->saveFile($photoAttributeName, $mediaPath, $fileDirectory);

                $result = $mediaPath . $result['file'];
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        } else {
            if (isset($data['logo']) && isset($data['logo']['value'])) {
                if (isset($data['logo']['delete'])) {
                    $fullFilePath = $this->getFileFullPath($data['logo']['value'], $fileDirectory);
                    $this->deleteFile($fullFilePath);
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
    }

    /**
     * @param string $filePath
     * @param string $fileDirectory
     * @return string
     */
    protected function getFileFullPath(string $filePath, string $fileDirectory = DirectoryList::MEDIA)
    {
        return $this->getMediaPath($fileDirectory)->getAbsolutePath($filePath);
    }

    /**
     * @param string $fullFilePath
     * @return bool
     * @throws FileSystemException
     */
    protected function fileExist(string $fullFilePath)
    {
        return $this->_file->isExists($fullFilePath);
    }

    /**
     * @param string $fullFilePath
     * @throws FileSystemException
     * @throws Exception
     */
    protected function deleteFile(string $fullFilePath)
    {
        if ($this->fileExist($fullFilePath)) {
            try {
                $this->_file->deleteFile($fullFilePath);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }

    /**
     * @param string $photoAttributeName
     * @param string $mediaPath
     * @param string $fileDirectory
     * @return array
     * @throws Exception
     */
    protected function saveFile(string $photoAttributeName, string $mediaPath, string $fileDirectory = DirectoryList::MEDIA)
    {
        $uploader = $this->_uploader->create(['fileId' => $photoAttributeName]);
        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
        $imageAdapter = $this->_adapterFactory->create();

        $uploader->addValidateCallback('logo', $imageAdapter, 'validateUploadFile');
        $uploader->setAllowRenameFiles(true);
        $uploader->setFilesDispersion(true);

        return $uploader->save($this->getFileFullPath($mediaPath, $fileDirectory));
    }
}
