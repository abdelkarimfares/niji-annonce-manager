<?php
declare(strict_types=1);

namespace Niji\AdManager\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;

/**
 * Banner Class
 *
 * This class is responsible for getting the current category id
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Banner extends Template
{
    /**
     * @param Registry $registry
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        private readonly Registry          $registry,
        Template\Context                   $context,
        array                              $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * Get the current category id
     *
     * @return int
     */
    public function getCurrentCategoryId(): int
    {
        return (int)$this->registry->registry('current_category')?->getId();
    }
}
