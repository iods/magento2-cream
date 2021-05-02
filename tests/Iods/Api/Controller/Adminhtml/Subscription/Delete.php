<?php

namespace AHT\ModuleHelloWorld\Controller\Adminhtml\Subscription;

class Delete extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'AHT_ModuleHelloWorld::index';

    const PAGE_TITLE = 'Delete subscription';

    protected $_subscriptionFactory;
    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \AHT\ModuleHelloWorld\Model\SubscriptionFactory $subscriptionFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_subscriptionFactory = $subscriptionFactory;
        parent::__construct($context);
    }


    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $id = $this->getRequest()->getParam('id');

            $contact = $this->_subscriptionFactory->create()->setId($id);
            $contact->delete();
            $this->messageManager->addSuccess(__('Successfully deleted the item.'));
            return $resultRedirect->setPath('*/*/test');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }

        return $resultRedirect;
    }

    /**
     * Is the user allowed to view the page.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }
}
