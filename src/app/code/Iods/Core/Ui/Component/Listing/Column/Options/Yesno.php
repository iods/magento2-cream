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

namespace Iods\Core\Ui\Component;

class Yesno implements \Magento\Framework\Data\OptionSourceInterface
{
    const OPTION_VALUE_YES = '1';
    const OPTION_VALUE_NO = '0';

    /**
     * @var array
     */
    protected $options;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            $this->options[self::OPTION_VALUE_YES]['label'] = 'Yes';
            $this->options[self::OPTION_VALUE_YES]['value'] = self::OPTION_VALUE_YES;

            $this->options[self::OPTION_VALUE_NO]['label'] = 'No';
            $this->options[self::OPTION_VALUE_NO]['value'] = self::OPTION_VALUE_NO;
        }

        return $this->options;
    }
}
