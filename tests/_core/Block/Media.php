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

namespace Iods\Core\Block;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;

/**
 * @package Common\Base
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_base
 */
abstract class Media extends Base
{
    protected $defaultMediaFileId = 'Common_Base::images/default.jpg';
    protected $mediaFolder = 'base';

    /**
     * @param Template\Context $context
     * @param array            $data
     */
    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @param string      $mediaFile
     * @param string|null $mediaFolder
     * @return string
     * @throws NoSuchEntityException
     */
    public function getMediaUrl($mediaFile, $mediaFolder = null)
    {
        if ($mediaFile) {
            $mediaFolder = $mediaFolder ?: $this->mediaFolder;
            $mediaDirectory = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA);
            if (is_file($mediaDirectory->getAbsolutePath($mediaFolder . '/' . $mediaFile))) {
                return $this->_storeManager->getStore()->getBaseUrl(DirectoryList::MEDIA) .
                    $mediaFolder . '/' . $mediaFile;
            }
        }
        return $this->getViewFileUrl($this->defaultMediaFileId);
    }
}
