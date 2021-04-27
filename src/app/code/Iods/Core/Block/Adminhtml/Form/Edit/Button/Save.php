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

namespace Iods\Core\Block\Adminhtml\Form\Edit\Button;

class Save extends AbstractSaveButton
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label'          => __($this->label ? $this->label : 'Save'),
            'class'          => $this->cssClass ? $this->cssClass : 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'disabled'       => !$this->canShowSaveButton(),
            'sort_order'     => $this->sortOrder ? $this->sortOrder : 90,
        ];
    }
}
