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
use Magento\Framework\App\Config\ScopeConfigInterface;


/**
 * Class Render
 * @package Cs2\Lfm\Plugin\Block
 */
class Render
{

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Render constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @param $subject
     * @param callable $proceed
     * @return string
     */
    public function aroundRenderNonCachedElement($subject, callable $proceed, $name)
    {
        $enabled = (boolean)$this->_scopeConfig->getValue(Config::PATH_BLOCK_INFO_ENABLE);
        if (!$enabled) {
            return $proceed($name);
        }

        $returnValue = '';

        if (!$subject->isUiComponent($name) && !$subject->isBlock($name)) {
            $returnValue .= "<!-- C: " . $name . " -->\n";
        }

        $returnValue .= $proceed($name);

        if (!$subject->isUiComponent($name) && !$subject->isBlock($name)) {
            $returnValue .= "\n<!-- C: " . $name . " | END -->";
        }

        return $returnValue;
    }
}
