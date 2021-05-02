<?php

namespace AHT\ModuleHelloWorld\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Dropdown implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => 'Yes'],
            ['value' => 0, 'label' => 'No']
        ];
    }
}
