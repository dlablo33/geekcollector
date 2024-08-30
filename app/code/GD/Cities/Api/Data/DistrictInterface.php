<?php
namespace GD\Cities\Api\Data;

interface DistrictInterface{


    const ID = 'district_id';
    const REGION_ID = 'region_id';
    const DEFAULT_NAME = 'default_name';
    /**
     * @return int
     */
    public function getId();
    /**
     * @return int
     */
    public function getRegionId();
    /**
     * @return string
     */
    public function getDefaultName();
    /**
     * @param int $id
     * @return void
     */
    public function setId($id);
    /**
     * @param int $regionId
     * @return void
     */
    public function setRegionId($regionId);
    /**
     * @param string $defaultName
     * @return void
     */
    public function setDefaultName($defaultName);



}
