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

namespace Iods\Core\Controller\Adminhtml;

use Exception;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\File\Uploader;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Store\Model\StoreManagerInterface;


abstract class AbstractUploadAction extends AbstractAjaxAction
{
    /**
     * @var WriteInterface
     */
    protected WriteInterface $mediaDirectory;

    /**
     * @var UploaderFactory
     */
    protected UploaderFactory $uploaderFactory;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @param UploadContext $context
     * @throws FileSystemException
     */
    public function __construct(UploadContext $context)
    {
        parent::__construct($context);

        $this->mediaDirectory = $context->getFilesystem()->getDirectoryWrite(DirectoryList::MEDIA);
        $this->uploaderFactory = $context->getUploaderFactory();
        $this->storeManager = $context->getStoreManager();
    }

    /**
     * @param string $folder  Folder path related to the media directory
     * @param array  $allowedExtensions
     * @return array|bool
     * @throws Exception
     */
    protected function save($folder, $allowedExtensions = [])
    {
        $fieldName = $this->getRequest()->getParam('param_name');

        /* @var Uploader $uploader */
        $uploader = $this->uploaderFactory->create(['fileId' => $fieldName]);
        $result = $uploader->setAllowRenameFiles(true)
            ->setFilesDispersion(false)
            ->setAllowedExtensions($allowedExtensions)
            ->save($this->mediaDirectory->getAbsolutePath($folder));

        unset($result['path']);
        $result['url'] = $this->storeManager->getStore()->getBaseUrl(DirectoryList::MEDIA)
            . $folder . '/' . $result['file'];

        return $result;
    }
}
