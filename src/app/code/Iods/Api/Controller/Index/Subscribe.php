<?php

namespace AHT\ModuleHelloWorld\Controller\Index;

use AHT\ModuleHelloWorld\Model\ResourceModel\Subscription as ResourceModelSubscription;

class Subscribe extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;
    protected $_resourceModel;
    protected $_subscriptionFactory;
    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        ResourceModelSubscription $resourceModel,
        \AHT\ModuleHelloWorld\Model\SubscriptionFactory $subscriptionFactory
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_resourceModel = $resourceModel;
        $this->_subscriptionFactory = $subscriptionFactory;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $model = $this->_subscriptionFactory->create();
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'message' => 'A short message to test'
        ];
        $model->addData($data);
        $this->_resourceModel->save($model);
        $this->getResponse()->setBody('success');
    }
}
