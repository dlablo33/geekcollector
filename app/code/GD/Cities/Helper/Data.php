<?php
namespace GD\Cities\Helper;

use GD\Cities\Constants\Constants;
use GD\Cities\Api\DistrictRepositoryInterface;
use GD\Cities\Api\Data\DistrictInterfaceFactory;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\File\Csv;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Exception\FileSystemException;
use Magento\Directory\Model\ResourceModel\Region\CollectionFactory;
use Magento\Directory\Model\RegionFactory;
use Psr\Log\LoggerInterface;
use Magento\Framework\Setup\SampleData\Context as SampleDataContext;

class Data extends AbstractHelper{
    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    protected $file;
    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csv;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;
    /**
     * @var \Magento\Directory\Model\ResourceModel\Region\Collection
     */
    protected $_regionCollection;
    /**
     * @var SampleDataContext
     */
    protected SampleDataContext $sampleDataContext;
    /**
     * @var CollectionFactory
     */
    protected $_regCollectionFactory;
    /**
     * @var DistrictRepositoryInterface
     */
    protected $districtRepository;
    /**
     * @var DistrictInterfaceFactory
     */
    protected $districtFactory;
    /**
     * @var RegionFactory
     */
    private $regionFactory;

    public function __construct(
        Context $context,
        File $file,
        Csv $csv,
        SampleDataContext $sampleDataContext,
        CollectionFactory $regCollectionFactory,
        DistrictRepositoryInterface $districtRepository,
        DistrictInterfaceFactory $districtFactory,
        RegionFactory $regionFactory,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->file = $file;
        $this->csv = $csv;
        $this->_regCollectionFactory = $regCollectionFactory;
        $this->districtRepository = $districtRepository;
        $this->districtFactory = $districtFactory;
        $this->sampleDataContext = $sampleDataContext;
        $this->regionFactory = $regionFactory;
        $this->logger = $logger;
    }

    public function importProcess(){
        $this->getCsvData();
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCsvData()
    {
        $collection = $this->_regCollectionFactory->create();
        $states = $collection->addCountryFilter(Constants::COUNTRY_ID)->load();

        foreach($states as $key) {
            $csvFileNamePath = Constants::IMPORT_PATH . '/_' . strtolower($key->getCode()) . '.csv';
            $csvFile = $this->sampleDataContext->getFixtureManager()->getFixture($csvFileNamePath);
            if (file_exists($csvFile)) {

                $region = $this->regionFactory->create();
                $region->loadByCode($key->getCode(), Constants::COUNTRY_ID);

                $rows = $this->csv->getData($csvFile);
                $count = 0;
                foreach ($rows as $row) {
                    if($count == 0 && strtolower(ltrim(rtrim($row[1]))) == 'municipio'){
                        $count++;
                        continue;
                    }
                    $this->logger->info('RegionId:' . $region->getRegionId() . ' - ' . $row[1]);
                    $this->setDataDistrict($region->getRegionId(), $row[1]);
                    $count++;
                }
            }
        }
    }

    protected function setDataDistrict($region_id, $name){
        $item = $this->districtFactory->create();
        $item->setRegionId($region_id);
        $item->setDefaultName($name);
        $this->districtRepository->save($item);
    }
}
