<?php
declare(strict_types=1);

namespace Niji\AdManager\Model\ResourceModel\Ad;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Ad Collection
 *
 * This class is responsible for performing a queries to fetch a collection of ads
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Collection extends AbstractCollection
{
    /**
     * @inheirtDoc
     */
    protected $_idFieldName = \Niji\AdManager\Model\ResourceModel\Ad::PRIMARY_KEY;

    protected function _construct()
    {
        $this->_init(
            \Niji\AdManager\Model\Ad::class,
            \Niji\AdManager\Model\ResourceModel\Ad::class
        );
    }

    /**
     * Get Ads Between Two Date
     *
     * @param string $date
     * @return $this
     */
    public function addDateFilter(string $date): static
    {
        $this->addFieldToFilter('started_at', ['lteq' => $date])
            ->addFieldToFilter('ended_at', ['gteq' => $date]);

        return $this;
    }

    /**
     * Add Category Filter
     *
     * @param int $categoryId
     * @return $this
     */
    public function addCategoryFilter(int $categoryId): static
    {
        $this->getSelect()->where(
            "FIND_IN_SET(?, `categories`)", $categoryId
        );

        return $this;
    }
}
