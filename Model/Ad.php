<?php
declare(strict_types=1);

namespace Niji\AdManager\Model;

use Magento\Framework\Model\AbstractModel;
use Niji\AdManager\Api\Data\AdInterface;

/**
 * Ad Form
 *
 * This class is responsible for performing update for ad entity
 *
 * @package    Niji\AdManager
 * @category   advertising
 * @author     Abdelkarim Fares <abdelkarimfares94@gmail.com>
 * @copyright  2024 Niji
 * @license    MIT License
 * @version    1.0.0
 * @link       https://github.com/abdelkarimfares/niji-annonce-manager
 */
class Ad extends AbstractModel implements AdInterface
{
    /**
     * @inheritdoc
     */
    protected function _construct(): void
    {
        $this->_init(\Niji\AdManager\Model\ResourceModel\Ad::class);
    }

    /**
     * @inheritDoc
     */
    public function getLabel(): string
    {
        return (string)$this->getData(self::LABEL);
    }

    /**
     * @inheritDoc
     */
    public function setLabel(string $label): static
    {
        $this->setData(self::LABEL, $label);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getContent(): string
    {
        return (string)$this->getData(self::CONTENT);
    }

    /**
     * @inheritDoc
     */
    public function setContent(string $content): static
    {
        $this->setData(self::CONTENT, $content);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLink(): string
    {
        return (string)$this->getData(self::LINK);
    }

    /**
     * @inheritDoc
     */
    public function setLink(string $link): static
    {
        $this->setData(self::LINK, $link);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStartedAt(): string
    {
        return (string)$this->getData(self::STARTED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setStartedAt(string $startedAt): static
    {
        $this->setData(self::STARTED_AT, $startedAt);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getEndedAt(): string
    {
        return (string)$this->getData(self::ENDED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setEndedAt(string $endedAt): static
    {
        $this->setData(self::ENDED_AT, $endedAt);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCategoryIds(): array
    {
        return explode(',', $this->getData(self::CATEGORIES) ?: '');
    }

    /**
     * @inheritDoc
     */
    public function setCategoryIds(array $categoryIds): static
    {
        $this->setData(self::CATEGORIES, implode(',', $categoryIds));

        return $this;
    }
}
