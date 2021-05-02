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

namespace Iods\Core\Plugin\Block;


/**
 * @package Asp\ConfigScopeGuide
 * @author Adam Sprada <adam.sprada@gmail.com>
 * @copyright 2020 Adam Sprada
 * @license See LICENSE for license details.
 */

namespace Asp\ConfigScopeGuide;

use Magento\Config\Model\Config\Structure\Element\Field;

/**
 * Class ConfigGuidePlugin
 */
class ConfigGuidePlugin
{
    /**
     * Add config path to comment section.
     *
     * @param Field $subject
     * @param string $comment
     *
     * @return string
     */
    public function afterGetComment(Field $subject, string $comment): string
    {
        $path = $subject->getConfigPath() ?: $subject->getPath();
        $path = sprintf('<code>Path: %s</code>', $path);

        if (strlen(trim($comment))) {
            $path .= '<br />';
        }

        return $path . $comment;
    }
}
