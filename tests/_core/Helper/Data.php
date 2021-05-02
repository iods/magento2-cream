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

# https://magento.stackexchange.com/a/74994
use Magento\Framework\App\Helper\Context;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Component\ComponentRegistrarInterface;

/**
 * Class Data
 * @package Iods\Core\Helper
 */
class Data extends AbstractHelper
{
    /** @var ComponentRegistrarInterface */
    private $componentRegistrarInterface;

    /**
     * @param Context $context
     * @param ComponentRegistrarInterface $componentRegistrarInterface
     */
    public function __construct(
        Context $context,
        ComponentRegistrarInterface $componentRegistrarInterface
    ) {
        parent::__construct($context);

        $this->componentRegistrarInterface = $componentRegistrarInterface;
    }

    /**
     * @return string
     */
    public function getModuleVersion(): string
    {
        $dir = $this->componentRegistrarInterface->getPath(
            ComponentRegistrar::MODULE,
            'Iods_Core'
        );

        $data = file_get_contents($dir . '/composer.json');
        $data = json_decode($data, true);

        if (empty($data['version'])) {
            return "Currently developing a new version. Stay tuned.";
        }

        return $data['version'];
    }
}
