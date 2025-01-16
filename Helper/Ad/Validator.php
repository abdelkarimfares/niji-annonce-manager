<?php
declare(strict_types=1);

namespace Niji\AdManager\Helper\Ad;

use Niji\AdManager\Api\Data\AdInterface;

/**
 * Ad Validator
 *
 * This class is responsible to validate the ad before saving it in database
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Validator
{
    /**
     * Validate the ad object
     *
     * @param AdInterface $ad
     * @return bool
     * @throws \Magento\Framework\Exception\ValidatorException
     */
    public function validate(AdInterface $ad): bool
    {
        if (!$this->greaterThan($ad->getLabel(), 2)) {
            throw new \Magento\Framework\Exception\ValidatorException(
                __("Label must be at least 2 characters long")
            );
        }

//        if (!$this->greaterThan($ad->getContent(), 5)) {
//            throw new \Magento\Framework\Exception\ValidatorException(
//                __("Content must be at least 5 characters long")
//            );
//        }

        if (!$ad->getStartedAt()) {
            throw new \Magento\Framework\Exception\ValidatorException(
                __("Started at date is required")
            );
        }

        if (!$ad->getEndedAt()) {
            throw new \Magento\Framework\Exception\ValidatorException(
                __("Ended at date is required")
            );
        }

        return true;
    }

    /**
     * @param string $value
     * @param int $length
     * @return bool
     */
    private function greaterThan(string $value, int $length): bool
    {
        return strlen(trim($value)) >= $length;
    }
}
