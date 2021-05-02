<?php

namespace AHT\ModuleHelloWorld\Api\Data;

use Magento\Framework\Api\CustomAttributesDataInterface;

interface SubscriptionInterface extends CustomAttributesDataInterface
{
    const SUBSCRIPTION_ID = 'subscription_id';
    const FIRSTNAME = 'firstname';
    const LASTNAME = 'lastname';
    const EMAIL = 'email';
    const STATUS = 'status';
    const MESSAGE = 'message';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get subscription id.
     *
     * @return int|null
     */
    public function getSubscriptionId();

    /**
     * Set subscription id.
     * @param int $subscriptionId
     * @return $this
     */
    public function setSubscriptionId($subscriptionId);

    /**
     * Get firstname.
     * 
     * @return string|null
     */
    public function getFirstname();


    /**
     * Set firstname.
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname);


    /**
     * Get lastname.
     * @return string|null
     */
    public function getLastname();


    /**
     * Set lastname.
     * 
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastname);


    /**
     * Get email.
     * 
     * @return string|null 
     */
    public function getEmail();


    /**
     * Set email.
     * 
     * @param string $email
     * @return $this
     */
    public function setEmail($email);


    /**
     * Get status.
     * 
     * @return string|null
     */
    public function getStatus();


    /**
     * Set status.
     * 
     * @param string $status
     * @return $this
     */
    public function setStatus($status);


    /**
     * Get message.
     * 
     * @return string|null
     */
    public function getMessage();


    /**
     * Set message.
     * 
     * @param mixed $message
     * @return $this
     */
    public function setMessage($message);


    /**
     * Get created at.
     * 
     * @return string|null
     */
    public function getCreatedAt();


    /**
     * Set created at.
     * 
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at);


    /**
     * Get updated at.
     * 
     * @return string|null
     */
    public function getUpdatedAt();


    /**
     * Set updated at.
     * 
     * @param string $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at);
}
