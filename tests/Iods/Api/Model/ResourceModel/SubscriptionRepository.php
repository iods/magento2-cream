<?php

namespace AHT\ModuleHelloWorld\Model\ResourceModel;

use AHT\ModuleHelloWorld\Api\Data\SubscriptionInterface;

class SubscriptionRepository implements \AHT\ModuleHelloWorld\Api\SubscriptionRepositoryInterface
{
    protected $_subscriptionFactory;
    protected $_subscriptionCollectionFactory;
    protected $_subscriptionResource;

    public function __construct(
        \AHT\ModuleHelloWorld\Model\SubscriptionFactory $subscriptionFactory,
        \AHT\ModuleHelloWorld\Model\ResourceModel\Subscription $subscriptionResource,
        \AHT\ModuleHelloWorld\Model\ResourceModel\Subscription\CollectionFactory $_subscriptionCollectionFactory
    ) {
        $this->_subscriptionFactory = $subscriptionFactory;
        $this->_subscriptionResource = $subscriptionResource;
        $this->_subscriptionCollectionFactory = $_subscriptionCollectionFactory;
    }

    public function getList()
    {
        $subscriptionCollection = $this->_subscriptionCollectionFactory->create()->getItems();
        return $subscriptionCollection;
    }

    public function getById($subscription_id)
    {
        $subscriptionFactory = $this->_subscriptionFactory->create();
        try {
            $subscription = $subscriptionFactory->load($subscription_id);
            if (is_null($subscription->getId())) {
                return null;
            } else {
                return $subscription;
            }
        } catch (\Exception $e) {
            return "Failure: " . $e->getMessage();
        }
    }

    public function save(SubscriptionInterface $subscription)
    {
        try {
            // $subscriptionFactory = $this->_subscriptionResource;
            if (is_null($subscription->getSubscriptionId())) {
                $this->_subscriptionResource->save($subscription);
                return "Success created subscription";
            } else {
                $this->_subscriptionResource->save($subscription);
                return "Success edited subscription";
            }
        } catch (\Exception $e) {
            return 'Failure: ' . $e->getMessage();
        }
    }

    public function delete(SubscriptionInterface $subscription)
    {
        $subscriptionFactory = $this->_subscriptionFactory->create()->setId($subscription->getSubscriptionId());
        try {
            $subscriptionFactory->delete();
            return "Success deleted model with id: {$subscription->getSubscriptionId()}";
        } catch (\Exception $e) {
            return "Fail: " . $e->getMessage();
        }
    }

    public function deleteById($subscription_id)
    {
        try {
            $subscriptionFactory = $this->getById($subscription_id);
            if (is_null($subscriptionFactory)) {
                throw new \Exception("Error Processing Request delete with id : {$subscription_id}", 1);
                return null;
            } else {
                $this->delete($subscriptionFactory);
                return "Success deleted subscription with id: {$subscription_id}";
            }
        } catch (\Exception $e) {
            return "Failure: " . $e->getMessage();
        }
    }
}
