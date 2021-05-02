<?php

namespace ViMagento\CustomApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface CustomInterface
 * @package ViMagento\CustomApi\Api\Data
 */
interface CustomInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * @return int
     */
    public function getView();

    /**
     * @param int $view
     * @return $this
     */
    public function setView($view);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);
}
