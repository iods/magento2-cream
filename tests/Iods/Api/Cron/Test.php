<?php

namespace AHT\ModuleHelloWorld\Cron;

class Test
{
    protected $logger;
    protected $objectManager;
    public function __construct(
        \Psr\Log\LoggerInterface
        $logger,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        $this->logger = $logger;
        $this->objectManager = $objectManager;
    }
    public function checkSubscriptions()
    {
        $subscription = $this->objectManager->create('AHT\ModuleHelloWorld\Model\Subscription');
        $subscription->setFirstname('Cron 3');
        $subscription->setLastname('Job');
        $subscription->setEmail('cron.job@example.com');
        $subscription->setMessage('Created from cron');
        $subscription->save();
        $this->logger->debug('Test subscription added');
    }
}
