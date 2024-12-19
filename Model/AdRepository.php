<?php
declare(strict_types=1);

namespace Niji\AdManager\Model;

use Niji\AdManager\Api\AdRepositoryInterface;
use Niji\AdManager\Api\Data\AdInterface;
use Niji\AdManager\Model\ResourceModel\Ad as AdResource;
use Psr\Log\LoggerInterface;

/**
 * Ad Repository
 *
 * This class is responsible for saving, deleting and updating the ad
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class AdRepository implements AdRepositoryInterface
{
    /**
     * @param AdFactory $adFactory
     * @param AdResource $adResource
     */
    public function __construct(
        protected AdFactory $adFactory,
        protected AdResource $adResource,
        protected LoggerInterface $logger
    ){}

    /**
     * @inheirtDoc
     */
    public function getById(int $AdId): AdInterface
    {
        $ad = $this->adFactory->create();
        $this->adResource->load($ad, $AdId);

        if (!$ad->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __("The ad that was requested doesn't exist. Verify the ad and try again.")
            );
        }

        return $ad;
    }

    /**
     * @inheirtDoc
     */
    public function save(AdInterface $ad): AdInterface
    {
        try {
            $this->adResource->save($ad);
        } catch (\Exception $e) {
            $this->logger->error($e);

            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Could not save the ad: %1', __('Something went wrong while saving the ad.'))
            );
        }

        return $ad;
    }

    /**
     * @inheirtDoc
     */
    public function delete(AdInterface $ad): bool
    {
        try {
            $this->adResource->delete($ad);
        } catch (\Exception $e) {
            $this->logger->error($e);

            throw new \Magento\Framework\Exception\CouldNotDeleteException(
                __(
                    'Cannot delete ad with id %1',
                    $ad->getId()
                ),
                $e
            );
        }

        return true;
    }
}