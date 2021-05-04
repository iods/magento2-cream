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


use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;


class Notices extends Template
{
    protected $dbStatusValidator;

    protected $configChangeDetector;

    public function __construct(
        Context $context,
        array $data = []
    ) {

        parent::__construct($context, $data);
    }

    public function hasErrors()
    {
        return $this->dbStatusValidator->hasErrors() || $this->configChangeDetector->hasErrors();
    }

    public function getErrorMessages()
    {
        return array_merge(
            $this->dbStatusValidator->getErrorMessages(),
            $this->configChangeDetector->getErrorMessages()
        );
    }
}
