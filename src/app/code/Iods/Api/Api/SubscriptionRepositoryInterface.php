<?php

namespace AHT\ModuleHelloWorld\Api;

interface SubscriptionRepositoryInterface
{
    /**
     * Get subscription list.
     *
     * @return \AHT\ModuleHelloWorld\Api\Data\SubscriptionInterface[]
     */
    public function getList();

    /**
     * Get subscription by given Subscription_Id.
     *
     * @param int $subscription_id
     * @return \AHT\ModuleHelloWorld\Api\Data\SubscriptionInterface
     */
    public function getById($subscription_id);

    /**
     * Save the subscription.
     *
     * @param \AHT\ModuleHelloWorld\Api\Data\SubscriptionInterface $subscription
     * @return \AHT\ModuleHelloWorld\Api\Data\SubscriptionInterface
     */
    public function save(\AHT\ModuleHelloWorld\Api\Data\SubscriptionInterface $subscription);

    /**
     * Delete the subscription model.
     *
     * @param \AHT\ModuleHelloWorld\Api\Data\SubscriptionInterface $subscription
     * @return bool
     */
    public function delete(\AHT\ModuleHelloWorld\Api\Data\SubscriptionInterface $subscription);

    /**
     * Delete the subscription by given id.
     *
     * @param int $subscription_id
     * @return bool
     */
    public function deleteById($subscription_id);
}
