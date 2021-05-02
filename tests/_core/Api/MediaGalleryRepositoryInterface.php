<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Core\Api;

interface MediaGalleryRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return \MageModule\Core\Api\Data\MediaGalleryInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($id);

    /**
     * @param \MageModule\Core\Api\Data\MediaGalleryInterface $object
     *
     * @return \MageModule\Core\Api\Data\MediaGalleryInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\MageModule\Core\Api\Data\MediaGalleryInterface $object);

    /**
     * @param \MageModule\Core\Api\Data\MediaGalleryInterface $object
     *
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(\MageModule\Core\Api\Data\MediaGalleryInterface $object);

    /**
     * @param int $id
     *
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($id);

    /**
     * @param int $entityId
     *
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteByEntityId($entityId);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria);
}
