<?php

namespace Elogic\Vendors\Model\Image;

use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Interface UploadImageInterface
 * @package Elogic\Vendors\Model\Image
 */
interface UploadImageInterface
{

    /**
     * @param array $data
     * @param string $photoAttributeName
     * @param array $requestFile
     * @param string $mediaPath
     * @param string $fileDirectory
     * @return mixed
     */
    public function uploadPhoto(array $data, string $photoAttributeName, array $requestFile, string $mediaPath, string $fileDirectory = DirectoryList::MEDIA);

    /**
     * @param string $filePath
     * @param string $fileDirectory
     * @return mixed
     */
    public function getFileFullPath(string $filePath, string $fileDirectory = DirectoryList::MEDIA);

    /**
     * @param string $fullFilePath
     * @return mixed
     */
    public function deleteFile(string $fullFilePath);
}
