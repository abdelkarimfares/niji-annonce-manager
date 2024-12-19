<?php
declare(strict_types=1);

namespace Niji\AdManager\Ui\DataProvider\Ad;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Niji\AdManager\Model\ResourceModel\Ad\CollectionFactory;

/**
 * Ad Model Functionalities
 *
 * In this class we will initialize the collection and form data
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Form extends AbstractDataProvider
{
    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        private readonly CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $this->collectionFactory->create();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }

        $items = $this->getCollection();
        $data = [];

        foreach ($items as $item) {
            $data[$item->getId()] = $item->getData();
            $data[$item->getId()]['categories'] = $item->getCategoryIds();
        }


        return $data;
    }
}