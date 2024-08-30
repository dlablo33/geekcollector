<?php
namespace GD\Cities\Block\Checkout;

use GD\Cities\Api\DistrictRepositoryInterface;
use GD\Cities\Api\Data\DistrictInterface;
use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Backend\Block\Template;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Backend\Block\Template\Context;

class CityUpdater extends Template
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
     * @var DistrictRepositoryInterface
     */
    protected $districtRepository;
    /** @var SerializerInterface  */
    protected $serializer;
    /**
     * @var AddressRepositoryInterface
     */
    protected $_addressRepository;
    /**
     * @var AddressRepositoryInterface
     */
    public $_customerAddress;

    /**
     * @param Context $context
     * @param AddressRepositoryInterface $addressRepository
     * @param DistrictRepositoryInterface $districtRepository
     * @param FilterBuilder $filterBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SerializerInterface $serializer
     * @param array $data
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        Context $context,
        AddressRepositoryInterface $addressRepository,
        DistrictRepositoryInterface $districtRepository,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SerializerInterface $serializer,
        array $data = []
    ){
        $this->_addressRepository = $addressRepository;
        $this->districtRepository = $districtRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->_districtRepository = $districtRepository;
        $this->serializer = $serializer;
        parent::__construct($context, $data);

        if ($addressId = $this->getRequest()->getParam('id')) {
            try {
                $this->_customerAddress = $this->_addressRepository->getById($addressId);
            } catch (NoSuchEntityException $e) {
                /*** error message */
            }
        }
    }

    /**
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getDistricts(){
         $return = [];
        if ($this->_customerAddress) {
            try {
                $filter = $this->filterBuilder->setField('region_id')
                    ->setConditionType('eq')
                    ->setValue($this->_customerAddress->getRegionId())
                    ->create();
                $this->searchCriteriaBuilder->addFilter($filter);
                $searchCriteria = $this->searchCriteriaBuilder->create();
                $items = $this->_districtRepository->getList($searchCriteria)->getItems();


                /** @var DistrictInterface $item */
                foreach ($items as $item) {
                    $return[] = ['region_id' => $item->getRegionId(), 'city_name' => $item->getDefaultName()];
                }

            } catch (NoSuchEntityException $e) {
                /*** error message */
            }
        }

        return $this->serializer->serialize($return);
    }

    /**
     * @return int|null
     */
    public function getRegionId(){
        return ($this->_customerAddress) ? $this->_customerAddress->getRegionId() : 0;
    }

    /**
     * @return string|null
     */
    public function getCity(){
        return ($this->_customerAddress) ? $this->_customerAddress->getCity() : "";
    }


}
