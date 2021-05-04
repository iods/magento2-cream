<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Core\Helper;
use Magento\Catalog\Model\Product\Image as ProductImage;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\Read;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Image\Adapter\ConfigInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;

class Image extends AbstractHelper
{
    const COUNT_IMAGES_TO_CALL = 50;
    const PUB_MEDIA_IMPORT_DIR = 'pub/media/import';

    protected $_directory;

    protected $_multiCurl;

    protected $_multiCurlCalls = [];

    protected $_folder;

    protected $_images = [];

    protected $_errorImages = [];

    protected $_allowedExtensions = [
        'png', 'jpg', 'jpeg', 'gif'
    ];

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Filesystem\DirectoryList $directory
    )
    {
        parent::__construct($context);
        $this->_directory = $directory;
    }

    public function init($folder) {
        $this->initCurl();
        $this->setFolder($folder);
    }

    protected function initCurl() {
        $this->_multiCurl = curl_multi_init();
    }

    public function finish() {
        if($this->_multiCurl) {
            curl_multi_close($this->_multiCurl);
        }
    }

    public function setFolder($folder) {
        $this->_folder = $folder;
    }

    public function fetchImages($noReOpen = false) {
        if(!$this->_multiCurl) {
            $this->initCurl();
        }

        if(count($this->_images)) {

            $directory = $this->getPubImportDirectory();
            $fullDir = $directory . DIRECTORY_SEPARATOR . $this->_folder;
            if(!is_dir($fullDir)) {
                mkdir($fullDir, 0775);
            }

            foreach($this->_images as $imageNewName => $_fecthUrl) {

                $this->_multiCurlCalls[$imageNewName] = curl_init();
                curl_setopt($this->_multiCurlCalls[$imageNewName], CURLOPT_URL, $_fecthUrl);
                curl_setopt($this->_multiCurlCalls[$imageNewName], CURLOPT_HEADER, 0);
                curl_setopt($this->_multiCurlCalls[$imageNewName], CURLOPT_RETURNTRANSFER,1);
                curl_setopt($this->_multiCurlCalls[$imageNewName], CURLOPT_TIMEOUT, 60);
                curl_multi_add_handle($this->_multiCurl, $this->_multiCurlCalls[$imageNewName]);
            }

            $running = null;
            //execute the handles
            do {

                curl_multi_exec($this->_multiCurl, $running);
                curl_multi_select($this->_multiCurl);

            } while ($running > 0);


            foreach($this->_multiCurlCalls as $imageNewName => $ch) {
                $contentImage = curl_multi_getcontent($ch);

                $savefile = fopen($fullDir . DIRECTORY_SEPARATOR . $imageNewName, 'w');
                fwrite($savefile, $contentImage);
                fclose($savefile);
                curl_multi_remove_handle($this->_multiCurl, $ch);
            }

            foreach($this->_images as $imageNewName => $_fecthUrl) {

                if(!is_file($fullDir . DIRECTORY_SEPARATOR . $imageNewName)) {
                    $this->setErrorImage($this->_folder . DIRECTORY_SEPARATOR . $imageNewName);
                    continue;
                }

                try{
                    list($width, $height, $type, $attr) = getimagesize($fullDir . DIRECTORY_SEPARATOR . $imageNewName);
                    if(!$width || $width < 1) {
                        $this->setErrorImage($this->_folder . DIRECTORY_SEPARATOR . $imageNewName);
                        continue;
                    }
                }catch (\Exception $e) {
                    $this->setErrorImage($this->_folder . DIRECTORY_SEPARATOR . $imageNewName);
                    continue;
                }

            }

            //erase images to fetch
            $this->_images = [];
            $this->_multiCurlCalls = [];

            /* close and resetup multicurl var */
            curl_multi_close($this->_multiCurl);

            $this->_multiCurl = null;
            //unset( $this->_multiCurl );
            if(!$noReOpen) {
                $this->_multiCurl = curl_multi_init();
                sleep(1);
            }
        }
    }

    public function clearErrorImages() {
        $this->_errorImages = [];
    }

    public function getErrorImages() {
        return $this->_errorImages;
    }

    protected function setErrorImage($imageName) {
        $this->_errorImages[] = $imageName;
    }

    public function setImage($image){
        $imageName = $image;
        if($this->checkIsUrl($image)) {
            $added = $this->_isExists( $image );
            if($added) {
                return $this->_folder . '/' . $added;
            }
            $imageName = $this->getImageName($image);
            if(!$imageName) {
                return '';
            }
            $this->_images[ $imageName ] = $image;
            $this->createImages();
            return $this->_folder . '/' . $imageName;
        }
        return $imageName;
    }

    protected function createImages() {
        if(count($this->_images) >= self::COUNT_IMAGES_TO_CALL) {
            $this->fetchImages();
        }
    }

    protected function _isExists($image) {
        foreach($this->_images as $imageNewName => $fetchUrl) {
            if($fetchUrl == $image) {
                return $imageNewName;
            }
        }
    }

    protected function getImageName($image) {
        $extension = $this->getExtension($image);
        if($extension) {
            return $this->getUniqueId() . '.' . $extension;
        }
    }

    protected function getUniqueId() {
        return uniqid(rand(), true);
    }

    protected function getExtension($image) {
        $path      = parse_url($image, PHP_URL_PATH);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if(in_array($extension, $this->_allowedExtensions)) {
            return $extension;
        }

    }

    protected function checkIsUrl($image) {
        if(strstr($image, 'http://') || strstr($image, 'https://')) {
            return true;
        }
    }

    protected function getPubImportDirectory() {
        $directory = $this->_directory->getRoot() . DIRECTORY_SEPARATOR . self::PUB_MEDIA_IMPORT_DIR;
        if(!is_dir($directory)) {
            mkdir($directory);
        }
        return $directory;
    }


    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var AdapterFactory
     */
    protected $imageFactory;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var Database
     */
    protected $coreFileStorageDatabase;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Read
     */
    protected $mediaDirectory;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param Context $context
     * @param Filesystem $filesystem
     * @param AdapterFactory $imageFactory
     * @param Database $coreFileStorageDatabase
     * @param StoreManagerInterface $storeManager
     * @param ConfigInterface $config
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        Filesystem $filesystem,
        AdapterFactory $imageFactory,
        Database $coreFileStorageDatabase,
        StoreManagerInterface $storeManager,
        ConfigInterface $config,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->filesystem = $filesystem;
        $this->imageFactory = $imageFactory;
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->storeManager = $storeManager;
        $this->config = $config;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * @return Read
     */
    protected function getMediaDirectory()
    {
        if (!$this->mediaDirectory) {
            $this->mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        }
        return $this->mediaDirectory;
    }

    /**
     * Get an image url
     * Saves file to FS if exists in database and not FS
     *
     * @param string $filename
     * @return string
     */
    public function get($filename)
    {
        $image = $this->prepareFilename($filename);
        $this->fileExists($image);
        return $this->getMediaImageUrl($image);
    }

    /**
     * Setup the image object ready for resizing/cropping
     *
     * @param string $image
     * @param int|null $width
     * @param int|null $height
     * @param array $options
     * @return \Magento\Framework\Image\Adapter\AdapterInterface
     */
    protected function setup($image, $width = null, $height = null, $options = [])
    {
        $imageAdapter = $this->imageFactory->create($this->config->getAdapterAlias());
        $imageAdapter->open($this->getMediaDirectory()->getAbsolutePath($image));

        $options = array_merge([
            'quality' => (int) $this->scopeConfig->getValue(ProductImage::XML_PATH_JPEG_QUALITY)
        ], $options);

        foreach ($options as $method => $value) {
            $imageAdapter->$method($value);
        }

        return $imageAdapter;
    }

    /**
     * Resize an image
     *
     * @param string $filename
     * @param int|null $width
     * @param int|null $height
     * @param array $options
     * @return string
     */
    public function resize($filename, $width = null, $height = null, $options = [])
    {
        $image = $this->prepareFilename($filename);

        if (!$this->fileExists($image)) {
            return $this->getMediaImageUrl($image);
        }

        $resizedImage = 'resized/' . $width . 'x' . $height . '/' . $image;
        if (!$this->fileExists($resizedImage)) {
            $imageResize = $this->setup($image, $width, $height, $options);
            $imageResize->resize($width, $height);
            $imageResize->save($this->getMediaDirectory()->getAbsolutePath($resizedImage));
        }

        return $this->getMediaImageUrl($resizedImage);
    }

    /**
     * Crop an image
     *
     * @param string $filename
     * @param int $width
     * @param int $height
     * @param array $options
     * @return string
     */
    public function crop($filename, $width, $height, $options = [])
    {
        $image = $this->prepareFilename($filename);

        if (!$this->fileExists($image)) {
            return $this->getMediaImageUrl($image);
        }

        $croppedImage = 'cropped/' . $width . 'x' . $height . '/' . $image;
        if (!$this->fileExists($croppedImage)) {
            $imageCrop = $this->setup($image, $width, $height, array_merge($options, ['constrainOnly' => false, 'keepAspectRatio' => true, 'keepFrame' => false]));

            $originalAspectRatio = $imageCrop->getOriginalWidth() / $imageCrop->getOriginalHeight();
            $aspectRatio = $width / $height;

            if ($aspectRatio < $originalAspectRatio) {
                $cropWidth = ceil($height * $originalAspectRatio);
                $cropHorizontal = ($cropWidth - $width) / 2;
                $imageCrop->resize($cropWidth, $height);
                $imageCrop->crop(0, $cropHorizontal, $cropHorizontal, 0);
            } else {
                $cropHeight = ceil($width / $originalAspectRatio);
                $cropVertical = ($cropHeight - $height) / 2;
                $imageCrop->resize($width, $cropHeight);
                $imageCrop->crop($cropVertical, 0, 0, $cropVertical);
            }

            $imageCrop->save($this->getMediaDirectory()->getAbsolutePath($croppedImage));
        }

        return $this->getMediaImageUrl($croppedImage);
    }

    /**
     * First check this file on FS
     * If it doesn't exist - try to download it from DB
     *
     * @param string $filename
     * @return bool
     */
    public function fileExists($filename)
    {
        $filename = $this->prepareFilename($filename);

        if ($this->getMediaDirectory()->isFile($filename)) {
            return true;
        } else {
            return $this->coreFileStorageDatabase->saveFileToFilesystem(
                $this->getMediaDirectory()->getAbsolutePath($filename)
            );
        }
    }

    /**
     * Get media image front-end url
     *
     * @param string|null $filename
     * @return string
     */
    public function getMediaImageUrl($filename)
    {
        return $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $filename;
    }

    /**
     * Prepare filename for handling by stripping any web path (i.e. when non-relative is passed tp helper)
     *
     * @param string $urlorfilename
     * @return string relative path
     */
    protected function prepareFilename($urlorfilename)
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        if (stristr($urlorfilename, '://')) {
            $urlorfilename = str_ireplace($mediaUrl, '', $urlorfilename);
        }

        $mediaPath = DIRECTORY_SEPARATOR . basename($mediaUrl) . DIRECTORY_SEPARATOR;

        if (stristr($urlorfilename, '://')) {
            return ltrim(stristr($urlorfilename, $mediaPath), $mediaPath);
        }

        return str_ireplace($mediaPath, DIRECTORY_SEPARATOR, $urlorfilename);
    }
}
