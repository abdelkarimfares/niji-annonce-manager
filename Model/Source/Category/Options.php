<?php

namespace Niji\AdManager\Model\Source\Category;

use Magento\Catalog\Model\Category as CategoryModel;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\App\Cache\Type\Block;
use Magento\Framework\App\CacheInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Options Class
 *
 * This class is responsible for getting the categories as tree options
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Options extends AbstractSource
{
    /**
     * CATEGORY CACHE IDENTIFIER
     */
    public const CATEGORY_CACHE_IDENTIFIER = 'NIJI_CATEGORY_TREE';

    /**
     * CATEGORY EMPTY
     */
    public const CATEGORY_EMPTY = '0';

    /**
     * @param CacheInterface $cache
     * @param SerializerInterface $serializer
     * @param CategoryCollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        private readonly CacheInterface $cache,
        private readonly SerializerInterface $serializer,
        private readonly CategoryCollectionFactory $categoryCollectionFactory
    ) {}

    /**
     * Retrieve all category options.
     *
     * @return array
     * @throws LocalizedException
     */
    public function getAllOptions(): array
    {
        $categoryTree = $this->loadCategoryTreeFromCache();

        if ($categoryTree) {
            return $categoryTree;
        }

        $shownCategoriesIds = $this->getShownCategoryIds();

        $categoryById = $this->buildCategoryTree($shownCategoriesIds);

        $this->cacheCategoryTree($categoryById);

        $this->addSelectOption($categoryById);

        return $categoryById[CategoryModel::TREE_ROOT_ID]['optgroup'];
    }

    /**
     * Load category tree from cache.
     *
     * @return array|null
     */
    private function loadCategoryTreeFromCache(): ?array
    {
        $cachedData = $this->cache->load(self::CATEGORY_CACHE_IDENTIFIER);
        return $cachedData ? $this->serializer->unserialize($cachedData) : null;
    }

    /**
     * Get IDs of categories to be shown.
     *
     * @return array
     * @throws LocalizedException
     */
    private function getShownCategoryIds(): array
    {
        $storeId = 0;
        $matchingNamesCollection = $this->categoryCollectionFactory->create();

        $matchingNamesCollection->addAttributeToSelect('path')
            ->addAttributeToFilter('entity_id', ['neq' => CategoryModel::TREE_ROOT_ID])
            ->setStoreId($storeId);

        $shownCategoriesIds = [];

        /** @var CategoryModel $category */
        foreach ($matchingNamesCollection as $category) {
            foreach (explode('/', $category->getPath()) as $parentId) {
                $shownCategoriesIds[$parentId] = true;
            }
        }

        return array_keys($shownCategoriesIds);
    }

    /**
     * Build category tree.
     *
     * @param array $shownCategoriesIds
     * @return array
     * @throws LocalizedException
     */
    private function buildCategoryTree(array $shownCategoriesIds): array
    {
        $storeId = 0;
        $collection = $this->categoryCollectionFactory->create();

        $collection->addAttributeToFilter('entity_id', ['in' => $shownCategoriesIds])
            ->addAttributeToSelect(['name', 'is_active', 'parent_id'])
            ->setStoreId($storeId);

        $categoryById = [
            CategoryModel::TREE_ROOT_ID => [
                'value' => CategoryModel::TREE_ROOT_ID,
                'optgroup' => null,
            ],
        ];

        /** @var CategoryModel $category */
        foreach ($collection as $category) {
            $this->processCategory($category, $categoryById);
        }

        return $categoryById;
    }

    /**
     * Process individual category and update category tree.
     *
     * @param CategoryModel $category
     * @param array $categoryById
     * @return void
     */
    private function processCategory(CategoryModel $category, array &$categoryById): void
    {
        foreach ([$category->getId(), $category->getParentId()] as $categoryId) {
            if (!isset($categoryById[$categoryId])) {
                $categoryById[$categoryId] = ['value' => $categoryId];
            }
        }

        $categoryById[$category->getId()]['is_active'] = $category->getIsActive();
        $categoryById[$category->getId()]['label'] = $category->getName();
        $categoryById[$category->getParentId()]['optgroup'][] = &$categoryById[$category->getId()];
    }

    /**
     * Cache the category tree.
     *
     * @param array $categoryById
     * @return void
     */
    private function cacheCategoryTree(array $categoryById): void
    {
        $this->cache->save(
            $this->serializer->serialize($categoryById[CategoryModel::TREE_ROOT_ID]['optgroup']),
            self::CATEGORY_CACHE_IDENTIFIER,
            [
                CategoryModel::CACHE_TAG,
                Block::CACHE_TAG
            ]
        );
    }

    /**
     * Add 'Select...' option to the category tree.
     *
     * @param array $categoryById
     * @return void
     */
    private function addSelectOption(array &$categoryById): void
    {
        $categoryById[CategoryModel::TREE_ROOT_ID]['optgroup'][] = [
            'value' => self::CATEGORY_EMPTY,
            'is_active' => true,
            'label' => __('Select...'),
        ];
    }
}
