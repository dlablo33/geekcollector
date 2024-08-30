<?php
namespace GD\Cities\Model;
use Monolog\Logger;

class CustomLogger extends \Magento\Framework\Logger\Handler\Debug
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/customfile.log';

    /**
     * @var int
     */
    protected $loggerType = Logger::INFO;
}
