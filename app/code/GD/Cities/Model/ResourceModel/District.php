<?php
namespace GD\Cities\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class District extends AbstractDb{
    protected function _construct()
    {
        $this->_init('directory_country_region_district', 'district_id');
    }
}
