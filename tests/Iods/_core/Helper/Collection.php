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

class Collection extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    private $localeDate;

    /**
     * Collection constructor.
     *
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Framework\App\Helper\Context                $context
     */
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
        $this->localeDate = $localeDate;
    }

    /**
     * Takes today's date, in the current timezone, and converts it for filtering timestamp column
     *
     * @param string $date
     *
     * @return string
     * @throws \Exception
     */
    public function getFromDateFilter($date)
    {
        /** @var \DateTime $datetime */
        $datetime = new \DateTime($date);
        $datetime->setTime(0, 0, 0);
        return $datetime->format(
            \Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT
        );
    }

    /**
     * Takes today's date, in the current timezone, and converts it for filtering timestamp column
     *
     * @param string $date
     *
     * @return string
     * @throws \Exception
     */
    public function getToDateFilter($date)
    {
        /** @var \DateTime $datetime */
        $datetime = new \DateTime($date);
        $datetime->setTime(23, 59, 59);
        return $datetime->format(
            \Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT
        );
    }
}
