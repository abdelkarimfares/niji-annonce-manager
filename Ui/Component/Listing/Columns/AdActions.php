<?php
declare(strict_types=1);

namespace Niji\AdManager\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Ad Grid Actions
 *
 * This class is responsible for preparing ad actions
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class AdActions extends Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        private readonly UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {

            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['edit'] = $this->getActionConfig(
                    (int)$item['entity_id'],
                    'nijiadmanager/ad/edit',
                    __('Edit')->render()
                );

                $item[$this->getData('name')]['delete'] = $this->getActionConfig(
                    (int)$item['entity_id'],
                    'nijiadmanager/ad/delete',
                    __('Delete')->render()
                );
            }
        }

        return $dataSource;
    }

    /**
     * @param int $id
     * @param string $action
     * @param string $label
     * @return array
     */
    private function getActionConfig(int $id, string $action, string $label): array
    {
        return [
            'href' => $this->urlBuilder->getUrl(
                $action,
                ['id' => $id, 'store' => $this->context->getFilterParam('store_id')]
            ),
            'label' => $label,
            'hidden' => false,
        ];
    }
}