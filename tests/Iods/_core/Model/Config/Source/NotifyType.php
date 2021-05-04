<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */

namespace Iods\Core\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class NotifyType implements ArrayInterface
{
    const TYPE_CODE = 'code';
    const TYPE_BUG = 'bug';
    const TYPE_MESSAGE = 'message';

    public function toOptionArray(): array
    {
        $options = [];

        foreach ($this->toArray() as $value => $label) {
            $options[] = [
                'value' => $value,
                'label' => $label
            ];
        }

        return $options;
    }

    public function toArray(): array
    {
        return [
            self::TYPE_CODE => __('Code Push (commit)'),
            self::TYPE_BUG => __('Bug Report (github issue)'),
            self::TYPE_MESSAGE => __('Messages (random messages)')
        ];
    }
}
