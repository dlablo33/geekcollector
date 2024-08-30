<?php
namespace GD\Cities\Model\ResourceModel\District;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection{

    public function _construct(){
        $this->_init('GD\Cities\Model\District', 'GD\Cities\Model\ResourceModel\District');
    }

}
