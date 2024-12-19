<?php
declare(strict_types=1);

namespace Niji\AdManager\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Ad Resource Model
 *
 * This class is bride between model and database
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Ad extends AbstractDb
{
    const TABLE_NAME = 'ad';
    const PRIMARY_KEY = 'entity_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::PRIMARY_KEY);
    }
}