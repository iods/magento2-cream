<?php
namespace Godogi\CodeTester\Controller\Index;
use Magento\Framework\App\Action\Context;
class Index extends \Magento\Framework\App\Action\Action
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
    public function execute()
    {
        echo 'Here you can test your code.';
    }
}