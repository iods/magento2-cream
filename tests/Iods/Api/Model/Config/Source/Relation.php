<?php

namespace AHT\ModuleHelloWorld\Model\Config\Source;

class Relation implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            [
                'value' => null,
                'label' => __('---Please Select---')
            ],
            [
                'value' => 'bronze',
                'label' => __("Bronze")
            ], [
                'value' => 'silver',
                'label' => __('Silver')
            ], [
                'value' => 'gold',
                'label' => __('Gold')
            ]
        ];
    }
}
