<?php
namespace GD\Cities\Model;

use GD\Cities\Api\DistrictRepositoryInterface;
use GD\Cities\Api\Data\DistrictInterface;
use GD\Cities\Api\Data\DistrictInterfaceFactory;
use GD\Cities\Api\Data\DistrictInterfaceFactoryFactory;
use GD\Cities\Api\Data\DistrictSearchResultsInterface;
use GD\Cities\Api\Data\DistrictSearchResultsInterfaceFactory;
use GD\Cities\Model\ResourceModel\District as ResourceDistrict;
use GD\Cities\Model\ResourceModel\District\CollectionFactory as DistrictCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class DistrictRepository implements DistrictRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ResourceDistrict
     */
    private $resource;
    /**
     * @var DistrictCollectionFactory
     */
    private $collectionFactory;
    /**
     * @var DistrictInterface
     */
    private $districtFactory;
    /**
     * @var DistrictInterfaceFactory
     */
    private $districtInterfaceFactory;
    /**
     * @var DistrictSearchResultsInterface
     */
    private $searchResultsFactory;

    /**
     * @param ResourceDistrict $resource
     * @param DistrictFactory $districtFactory
     * @param DistrictInterfaceFactory $districtInterfaceFactory
     * @param DistrictCollectionFactory $collectionFactory
     * @param DistrictSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceDistrict                      $resource,
        DistrictFactory                       $postFactory,
        DistrictInterfaceFactory              $postInterfaceFactory,
        DistrictCollectionFactory             $collectionFactory,
        DistrictSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface          $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->districtFactory = $postFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->districtInterfaceFactory = $postInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
    }
    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }
    /**
     * @param DistrictInterface $district
     * @return bool
     */
    public function delete(DistrictInterface $district): bool
    {
        try {
            $this->resource->delete($district);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the district: %1', $exception->getMessage())
            );
        }
        return true;
    }
    /**
     * @param int $id
     * @return DistrictInterface
     */
    public function getById(int $id): DistrictInterface
    {
        $item = $this->districtFactory->create();
        $this->resource->load($item, $id);
        if (!$item->getId()) {
            throw new NoSuchEntityException(__('The district with the "%1" ID doesn\'t exist.', $id));
        }
        return $item;
    }
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
    /**
     * @param DistrictInterface $district
     * @return DistrictInterface
     * @throws CouldNotSaveException
     */
    public function save(DistrictInterface $district): DistrictInterface
    {
        try {
            $this->resource->save($district);
        } catch (LocalizedException $exception) {
            throw new CouldNotSaveException(
                __('Could not save the district: %1', $exception->getMessage()),
                $exception
            );
        } catch (\Throwable $exception) {
            throw new CouldNotSaveException(
                __('Could not save the district: %1', __('Something went wrong while saving the district.')),
                $exception
            );
        }
        return $district;
    }
}
