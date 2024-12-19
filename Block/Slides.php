<?php
declare(strict_types=1);

namespace Niji\AdManager\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;
use Niji\AdManager\Model\ResourceModel\Ad\CollectionFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Registry;

/**
 * Slides Class
 *
 * This class is responsible for filtering the ads by category and date
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Slides extends Template
{
    /**
     * @var array|null
     */
    private ?array $items = null;

    /**
     * @param CollectionFactory $collectionFactory
     * @param DateTime $dateTime
     * @param Registry $registry
     * @param RequestInterface $request
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        private readonly CollectionFactory $collectionFactory,
        private readonly DateTime          $dateTime,
        private readonly Registry          $registry,
        private readonly RequestInterface $request,
        Template\Context                   $context,
        array                              $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * @return int
     */
    private function getCurrentCategoryId(): int
    {
        return (int)$this->request->getParam('category')
            ?: $this->registry->registry('current_category')?->getId();
    }

    /**
     * Get Active ads for the current category
     *
     * @return array
     */
    public function getActiveAds(): array
    {
        if (!$this->items) {
            $categoryId = $this->getCurrentCategoryId();
            $currentDate = $this->dateTime->gmtDate('Y-m-d');

            if (!$categoryId) {
                return [];
            }

            $collection = $this->collectionFactory->create();
            $collection->addDateFilter($currentDate)
                ->addCategoryFilter($categoryId);

            $this->items = array_values($collection->getItems());
        }

        return $this->items;
    }
}
