<?php

namespace AHT\ModuleHelloWorld\Controller\Adminhtml\Subscription;

class Save extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'AHT_ModuleHelloWorld::index';

    protected $resultPageFactory;
    protected $subscriptionFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \AHT\ModuleHelloWorld\Model\SubscriptionFactory $subscriptionFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->subscriptionFactory = $subscriptionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $id = $data['subscription_id'];

                $contact = $this->subscriptionFactory->create()->load($id);

                $data = array_filter($data, function ($value) {
                    return $value !== '';
                });

                $contact->setData($data);
                $contact->save();
                $this->messageManager->addSuccess(__('Successfully saved the item.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                return $resultRedirect->setPath('*/*/test');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['id' => $contact->getId()]);
            }
        }

        return $resultRedirect->setPath('*/*/test');
    }
}
