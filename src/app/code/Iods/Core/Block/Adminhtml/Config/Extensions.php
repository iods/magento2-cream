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

namespace Iods\Core\Block\Adminhtml\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;


class Extensions extends Template implements RendererInterface
{

    const MODULE_NAME = 'TIG_Core';

    /**
     * @var string
     */
    protected $_template = 'TIG_Core::adminhtml/config/extensions.phtml';

    /**
     * @var Extension
     */
    private $extension;

    /**
     * @var $extensionFactory
     */
    private $extensionFactory;

    /**
     * @var $fullModuleList
     */
    protected $fullModuleList;

    /**
     * @var \Magento\Framework\Module\Manager
     */
    private $moduleManager;

    /**
     * Extensions constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Extension $extension,
        ExtensionFactory $extensionFactory,
        \Magento\Framework\Module\FullModuleList $fullModuleList,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    )
    {
        $this->extensionFactory = $extensionFactory;
        $this->extension = $extension;
        $this->moduleManager = $moduleManager;
        $this->fullModuleList = $fullModuleList;
        parent::__construct($context, $data);

    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }

    /**
     * @return array|bool|mixed
     */
    public function generateExtensionsList()
    {
        $extensionList = $this->extension->generateModuleList();
        if (!$extensionList) {
            return false;
        }
        return $extensionList;
    }
}
