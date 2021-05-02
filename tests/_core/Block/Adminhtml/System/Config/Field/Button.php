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

namespace Iods\Core\Block\Adminhtml\System\Config\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * @package Common\Base
 * @author  Zengliwei <zengliwei@163.com>
 * @url https://github.com/zengliwei/magento2_base
 */
class Button extends Field
{
    protected function _getElementHtml(AbstractElement $element)
    {
        /* @var $buttonBlock \Magento\Backend\Block\Widget\Button */
        $buttonBlock = $this->getLayout()->createBlock(\Magento\Backend\Block\Widget\Button::class);

        $fieldConfig = $element->getDataByKey('field_config');
        $url = $buttonBlock->getUrl(
            $fieldConfig['button_url'],
            [
                'website' => $buttonBlock->getRequest()->getParam('website'),
                'store'   => $buttonBlock->getRequest()->getParam('store')
            ]
        );
        return $buttonBlock->setData(
            [
                'label'   => __($fieldConfig['button_label']),
                'onclick' => 'setLocation("' . $buttonBlock->escapeUrl($url) . '")'
            ]
        )->toHtml();
    }
}
