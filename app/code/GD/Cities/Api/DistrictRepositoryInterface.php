<?php
namespace GD\Cities\Api;

use GD\Cities\Api\Data\DistrictInterface;
use GD\Cities\Api\Data\DistrictSearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface DistrictRepositoryInterface
{
    /**
     * Delete district.
     *
     * @param DistrictInterface $district
     * @return bool
     * @throws LocalizedException
     */
    public function delete(DistrictInterface $district): bool;
    /**
     * Delete district by ID.
     *
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $id): bool;
    /**
     * Retrieve district.
     *
     * @param int $id
     * @return DistrictInterface
     * @throws LocalizedException
     */
    public function getById(int $id): DistrictInterface;
    /**
     * Retrieve districts matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;
    /**
     * Save post.
     *
     * @param DistrictInterface $district
     * @return DistrictInterface
     * @throws LocalizedException
     */
    public function save(DistrictInterface $district): DistrictInterface;
}
