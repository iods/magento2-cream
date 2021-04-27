<?php declare(strict_types=1);
/**
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade the modules
 * in the Darkstar Magento 2 Suite to newer versions in the future.
 *
 * @category  Iods
 * @package   Iods_Developer
 * @version
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2020, Rye Miller (http://ryemiller.io)
 * @license   MIT (https://en.wikipedia.org/wiki/MIT_License)
 */

namespace Iods\Developer\Block\Adminhtml\System\Config\Field;

use Iods\Developer\Helper\Data;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Version
 * @package Iods\Developer\Block\Adminhtml\System\Config\Field
 */
class Version extends Field
{
    /** @var Data */
    protected $_helper;

    /**
     * @param Context $context
     * @param Data $helper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->_helper = $helper;
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        return $this->_helper->getModuleVersion();
    }
}
