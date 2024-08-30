<?php
namespace GD\Cities\Model;

use GD\Cities\Api\Data\DistrictInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class District extends AbstractExtensibleModel implements DistrictInterface, IdentityInterface
{

    const CACHE_TAG = 'GD_Cities_Model_District';

    protected function _construct()
    {
        $this->_init('GD\Cities\Model\ResourceModel\District');
        $this->setIdFieldName('district_id');
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->getData('district_id');
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->setData('district_id', $id);
        return $this;
    }
    /**
     * @return string
     */
    public function getDefaultName()
    {
        return $this->getData('default_name');
    }
    /**
     * @param $name
     * @return $this
     */
    public function setDefaultName($name)
    {
        $this->setData('default_name', $name);
        return $this;
    }
    /**
     * @return int
     */
    public function getRegionId()
    {
        return $this->getData('region_id');
    }
    /**
     * @param $regionId
     * @return $this
     */
    public function setRegionId($regionId)
    {
        $this->setData('region_id', $regionId);
        return $this;
    }
    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
