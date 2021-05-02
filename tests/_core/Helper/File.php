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

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;

class File extends AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    private $directoryList;

    /**
     * @var \Magento\Framework\Filesystem\Io\File
     */
    private $fileIo;

    protected $objectManager;
    protected $helperLog;
    protected $directoryList;
    protected $fileDriver;

    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        LogHelper $helperLog,
        DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Driver\File $fileDriver
    ) {
        parent::__construct($context, $objectManager);
        $this->helperLog = $helperLog;
        $this->directoryList = $directoryList;
        $this->fileDriver = $fileDriver;
    }

    public function getRootPath()
    {
        return $this->directoryList->getRoot();
    }

    public function fileExists($path = null)
    {
        return $this->fileDriver->isExists($path) && $this->fileDriver->isFile($path);
    }

    public function deleteFile($path = null)
    {
        return $this->fileDriver->deleteFile($path);
    }

    public function getFiles($path = null, $extension = null)
    {
        $files = [];
        $fullPath = $this->getRootPath() . $path;
        $directoryFiles = $this->fileDriver->readDirectory($fullPath);
        array_walk($directoryFiles, function ($file) use (&$files, &$extension) {
            $this->processFile($files, $file, $extension);
        });
        return $files;
    }

    protected function processFile(&$files = [], $file = null, $extension = null)
    {
        if ($this->getFileExtension($file) === $extension) {
            $files[] = $file;
        }
    }

    public function getFileExtension($filename = null)
    {
        return substr(strrchr($filename, '.'), 1);
    }

    public function getFileSize($filename = null)
    {
        return $this->fileExists($filename) ? $this->fileDriver->stat($filename)['size'] : 0;
    }

    public function getRootFilePath($path = null, $filename = null)
    {
        return $this->getRootPath() . "/$path/$filename";
    }

    public function getDirectoryPath($path = null)
    {
        return $this->getRootPath() . "/" . $path;
    }

    public function getFilePath($path = null, $filename = null)
    {
        return "$path/$filename";
    }

    public function getFileContents($path = "", $filename = "")
    {
        return $this->fileDriver->fileGetContents($this->getFilePath($path, $filename));
    }

    /**
     * File constructor.
     *
     * @param \Magento\Framework\App\Helper\Context           $context
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directoryList
     * @param \Magento\Framework\Filesystem\Io\File           $fileIo
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Io\File $fileIo
    ) {
        parent::__construct($context);
        $this->directoryList = $directoryList;
        $this->fileIo        = $fileIo;
    }

    /**
     * If the filepath begins with "/" it is considered to already be the absolute path. If it does
     * not begin with a "/" then the Magento root path will be prepended to the filepath
     *
     * @param string $filepath
     *
     * @return string
     */
    public function getAbsolutePath($filepath)
    {
        if (strpos($filepath, DIRECTORY_SEPARATOR) !== 0) {
            $filepath = $this->assembleFilepath([
                $this->directoryList->getRoot(),
                $filepath
            ]);
        }

        return $filepath;
    }

    /**
     * @param string $filepath
     *
     * @return string
     */
    public function getRelativePath($filepath)
    {
        $root = $this->directoryList->getRoot();
        if (strpos($filepath, $root) === 0) {
            $filepath = ltrim(substr($filepath, strlen($root)), DIRECTORY_SEPARATOR);
        }

        return $filepath;
    }

    /**
     * @param array  $parts
     * @param bool   $absolute
     * @param string $glue
     *
     * @return string
     */
    public function assembleFilepath(array $parts, $absolute = true, $glue = DIRECTORY_SEPARATOR)
    {
        $parts = array_map(function ($value) use ($glue) {
            return trim($value, $glue);
        }, $parts);

        $filepath = implode($glue, $parts);
        if ($absolute === true) {
            $filepath = $glue . $filepath;
        }

        return $filepath;
    }

    /**
     * Is file exists
     *
     * @param string $file
     * @param bool   $onlyFile
     *
     * @return bool
     */
    public function fileExists($file, $onlyFile = true)
    {
        return $this->fileIo->fileExists($file, $onlyFile);
    }

    /**
     * @param string $filepath
     *
     * @return string|null
     */
    public function getDirname($filepath)
    {
        $info = $this->fileIo->getPathInfo($filepath);

        return isset($info['dirname']) ? $info['dirname'] : null;
    }

    /**
     * @param string $filepath
     *
     * @return string|null
     */
    public function getBasename($filepath)
    {
        $info = $this->fileIo->getPathInfo($filepath);

        return isset($info['basename']) ? $info['basename'] : null;
    }

    /**
     * @param string $filepath
     *
     * @return string|null
     */
    public function getExtension($filepath)
    {
        $info = $this->fileIo->getPathInfo($filepath);

        return isset($info['extension']) ? $info['extension'] : null;
    }

    /**
     * @param string $filepath
     *
     * @return string|null
     */
    public function getFilename($filepath)
    {
        $info = $this->fileIo->getPathInfo($filepath);

        return isset($info['filename']) ? $info['filename'] : null;
    }
}
