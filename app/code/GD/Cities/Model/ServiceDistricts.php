<?php
namespace GD\Cities\Model;

use GD\Cities\Api\DistrictRepositoryInterface;
use GD\Cities\Api\Data\DistrictInterface;
use GD\Cities\Api\ServiceDistrictsInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;

class ServiceDistricts implements ServiceDistrictsInterface
{
    /**
     * @var DistrictRepositoryInterface
     */
    protected $_districtRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @param DistrictRepositoryInterface $districtRepository
     * @param FilterBuilder $filterBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(DistrictRepositoryInterface $districtRepository, FilterBuilder $filterBuilder, SearchCriteriaBuilder $searchCriteriaBuilder)
    {
        $this->_districtRepository = $districtRepository;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param int $region_id
     * @return DistrictInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCitiesForRegion(int $region_id): array
    {

        $filter = $this->filterBuilder->setField('region_id')
            ->setConditionType('eq')
            ->setValue($region_id)
            ->create();
        $this->searchCriteriaBuilder->addFilter($filter);
        $searchCriteria = $this->searchCriteriaBuilder->create();

        return $this->_districtRepository->getList($searchCriteria)->getItems();

    }
}
