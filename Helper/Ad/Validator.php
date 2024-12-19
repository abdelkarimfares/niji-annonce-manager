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
        if (strlen(trim($ad->getLabel())) <= 2) {
            throw new \Magento\Framework\Exception\ValidatorException(
                __("Label must be at least 2 characters long")
            );
        }

        if (strlen(trim($ad->getContent())) <= 5) {
            throw new \Magento\Framework\Exception\ValidatorException(
                __("Label must be at least 5 characters long")
            );
        }

        return true;
    }
}
