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

namespace Iods\Core\Console\Command;

use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{
    private array $defaultOptions;

    public function __construct(
        $defaultOptions = [],
        $name = null
    ) {
        $this->defaultOptions = $defaultOptions;
        parent::__construct($name);
    }

    public function getDefaultOption($option): string|null
    {
        return array_key_exists($option, $this->defaultOptions) ? $this->defaultOptions[$option] : null;
    }
}
