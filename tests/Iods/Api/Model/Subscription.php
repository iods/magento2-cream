<?php

namespace AHT\ModuleHelloWorld\Model;

use Magento\Framework\Api\CustomAttributesDataInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Subscription extends \Magento\Framework\Model\AbstractModel implements \AHT\ModuleHelloWorld\Api\Data\SubscriptionInterface
{
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_DECLINED = 'declined';
    protected $subscriptionDataFactory;
    protected $dataObjectHelper;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource =
        null,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \AHT\ModuleHelloWorld\Api\Data\SubscriptionInterfaceFactory $subscriptionDataFactory,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection =
        null,
        array $data = []
    ) {
        $this->dataObjectHelper = $dataObjectHelper;

        $this->subscriptionDataFactory = $subscriptionDataFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }
    public function _construct()
    {
        $this->_init('AHT\ModuleHelloWorld\Model\ResourceModel\Subscription');
    }

    public function getDataModel()
    {
        $subscriptionData = $this->getData();

        $subscriptionDataObject = $this->subscriptionDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $subscriptionDataObject,
            $subscriptionData,
            \AHT\ModuleHelloWorld\Api\Data\SubscriptionInterface::class
        );
        return $subscriptionDataObject;
    }

    public function retrieve($subscription_id)
    {

        $subscription = $this->subscriptionFactory->create()->load($subscription_id);
        if (!$subscription->getId()) {
            // subscription does not exist
            throw NoSuchEntityException::singleField('subscription_id', $subscription_id);
        } else {
            return $subscription;
        }
    }

    /**
     * @inheritDoc
     */
    public function getSubscriptionId()
    {
        return $this->getData(self::SUBSCRIPTION_ID);
    }

    /**
     * @inheritDoc
     */
    public function setSubscriptionId($subscriptionId)
    {
        $this->setData(self::SUBSCRIPTION_ID, $subscriptionId);
    }

    /**
     * @inheritDoc
     */
    public function getFirstname()
    {
        return $this->getData(self::FIRSTNAME);
    }

    /**
     * @inheritDoc
     */
    public function setFirstname($firstname)
    {
        $this->setData(self::FIRSTNAME, $firstname);
    }

    /**
     * @inheritDoc
     */
    public function getLastname()
    {
        return $this->getData(self::LASTNAME);
    }

    /**
     * @inheritDoc
     */
    public function setLastname($lastname)
    {
        $this->setData(self::LASTNAME, $lastname);
    }

    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail($email)
    {
        $this->setData(self::EMAIL, $email);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * @inheritDoc
     */
    public function setMessage($message)
    {
        $this->setData(self::MESSAGE, $message);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt($created_at)
    {
        $this->setData(self::CREATED_AT, $created_at);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt($updated_at)
    {
        $this->setData(self::UPDATED_AT, $updated_at);
    }

    public function getCustomAttribute($attributeCode)
    {
    }

    public function getCustomAttributes()
    {
    }

    public function setCustomAttribute($attributeCode, $attributeValue)
    {
    }

    public function setCustomAttributes(array $attributes)
    {
    }
}
