<?php
namespace GD\Cities\Api\Data;
use Magento\Framework\Api\SearchResultsInterface;

interface DistrictSearchResultsInterface extends SearchResultsInterface{

    /**
     * Get post list.
     *
     * @return DistrictInterface[]
     */
    public function getItems(): array;
    /**
     * Set post list.
     *
     * @param DistrictInterface[] $items
     * @return $this
     */
    public function setItems(array $items);

}
