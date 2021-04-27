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

namespace Iods\Core\Framework\File;

use Magento\Framework\Exception\LocalizedException;


class Csv extends \Magento\Framework\File\Csv
{
    /**
     * @var \MageModule\Core\Framework\Io\File
     */
    private $ioFile;

    /**
     * Csv constructor.
     *
     * @param \MageModule\Core\Framework\Io\File        $ioFile
     * @param \Magento\Framework\Filesystem\Driver\File $file
     */
    public function __construct(
        \MageModule\Core\Framework\Io\File $ioFile,
        \Magento\Framework\Filesystem\Driver\File $file
    ) {
        parent::__construct($file);
        $this->ioFile = $ioFile;
    }

    /**
     * @param string|null $delimiter
     *
     * @return bool
     */
    public function validateDelimiter($delimiter)
    {
        if ($delimiter == '\t') {
            $delimiter = "\t";
        }

        return $delimiter === null ||
               $delimiter === '' ||
               strlen($delimiter) === 1 ||
               $delimiter === "\t";
    }

    /**
     * @param string $enclosure
     *
     * @return bool
     */
    public function validateEnclosure($enclosure)
    {
        return $enclosure === null || $enclosure === '' || strlen($enclosure) === 1;
    }

    /**
     * @param string $delimiter
     *
     * @return \Magento\Framework\File\Csv
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function setDelimiter($delimiter)
    {
        if (!$this->validateDelimiter($delimiter)) {
            throw new LocalizedException(
                __('CSV delimiters can only be one character in length unless using \t for "tab".')
            );
        }

        return parent::setDelimiter($delimiter);
    }

    /**
     * @param string $enclosure
     *
     * @return \Magento\Framework\File\Csv
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function setEnclosure($enclosure)
    {
        if (!$this->validateEnclosure($enclosure)) {
            throw new LocalizedException(
                __('CSV field enclosures can only be one character in length.')
            );
        }

        return parent::setEnclosure($enclosure);
    }

    /**
     * @param string $file
     *
     * @return $this
     */
    public function setStream($file)
    {
        $this->ioFile->setStream($file);

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetStream()
    {
        $this->ioFile->unsetStream();

        return $this;
    }

    /**
     * @param bool $exclusive
     *
     * @return $this
     */
    public function streamLock($exclusive = true)
    {
        $this->ioFile->streamLock($exclusive);

        return $this;
    }

    /**
     * @return $this
     */
    public function streamUnlock()
    {
        $this->ioFile->streamUnlock();

        return $this;
    }

    /**
     * @return false|array
     */
    public function streamReadCsv()
    {
        return $this->ioFile->streamReadCsv(
            $this->_delimiter,
            $this->_enclosure
        );
    }
}
