<?php
namespace GD\Cities\Api;

use GD\Cities\Api\Data\DistrictInterface;

interface ServiceDistrictsInterface
{
    /**
     * @param int $region_id
     * @return DistrictInterface[];
     */
    public function getCitiesForRegion(int $region_id): array;
}
