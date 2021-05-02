<?php

namespace ViMagento\CustomApi\Controller\Custom;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $customRepository;

    public function __construct(
        \ViMagento\CustomApi\Model\CustomRepository $customRepository,
        Context $context
    ) {
        $this->customRepository = $customRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $a = $this->customRepository->getById(1);
        echo "<pre>";
        var_dump($a->getData());
        echo "</pre>";
    }
}
