<?php

namespace AHT\ModuleHelloWorld\Plugin\Catalog;

class ProductAround
{
    public function aroundGetName($interceptedInput)
    {
        return "Name of product";
    }
}
