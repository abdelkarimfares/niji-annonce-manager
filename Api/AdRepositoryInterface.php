<?php

namespace Niji\AdManager\Api;

use Niji\AdManager\Api\Data\AdInterface;

/**
 * @api
 */
interface AdRepositoryInterface
{
    /**
     * @param int $adId
     * @return AdInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $adId): AdInterface;

    /**
     * Create Ad
     *
     * @param AdInterface $ad
     * @return AdInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(AdInterface $ad): AdInterface;

    /**
     * Delete Ad
     *
     * @param AdInterface $ad
     * @return bool Will returned True if deleted
     * * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(AdInterface $ad): bool;
}
