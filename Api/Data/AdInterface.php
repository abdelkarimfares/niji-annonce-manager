<?php

namespace Niji\AdManager\Api\Data;

/**
 * Interface AdInterface
 *
 * Defines the contract for Ad data operations.
 */
interface AdInterface
{
    const ID = 'entity_id';
    const LABEL = 'label';
    const CONTENT = 'content';
    const LINK = 'link';
    const STARTED_AT = 'started_at';
    const ENDED_AT = 'ended_at';
    const CATEGORIES = 'categories';

    /**
     * Retrieve Ad Label
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Set Ad Label
     *
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label): static;

    /**
     * Retrieve Ad Content
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Set Ad Content
     *
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): static;

    /**
     * Retrieve ad link
     *
     * @return string
     */
    public function getLink(): string;

    /**
     * Set Ad Link
     *
     * @param string $link
     * @return $this
     */
    public function setLink(string $link): static;

    /**
     * Retrieve the start date
     *
     * @return string
     */
    public function getStartedAt(): string;

    /**
     * Set start date
     *
     * @param string $startedAt
     * @return $this
     */
    public function setStartedAt(string $startedAt): static;

    /**
     * Retrieve the end date
     *
     * @return string
     */
    public function getEndedAt(): string;

    /**
     * Set the end date
     *
     * @param string $endedAt
     * @return $this
     */
    public function setEndedAt(string $endedAt): static;

    /**
     * Retrieve assigned category IDs.
     *
     * @return int[]
     */
    public function getCategoryIds(): array;

    /**
     * Set assigned category IDs.
     *
     * @param int[] $categoryIds
     * @return static
     */
    public function setCategoryIds(array $categoryIds): static;
}