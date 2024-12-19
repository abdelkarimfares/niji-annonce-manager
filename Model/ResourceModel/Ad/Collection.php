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
    protected $_idFieldName = \Niji\AdManager\Model\ResourceModel\Ad::PRIMARY_KEY;

    protected function _construct()
    {
        $this->_init(
            \Niji\AdManager\Model\Ad::class,
            \Niji\AdManager\Model\ResourceModel\Ad::class
        );
    }
}