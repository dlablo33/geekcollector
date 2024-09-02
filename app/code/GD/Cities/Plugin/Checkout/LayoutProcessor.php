<?php
namespace GD\Cities\Plugin\Checkout;
use Magento\Checkout\Block\Checkout\LayoutProcessor as LayoutProcessorSubject;
use Psr\Log\LoggerInterface;

class LayoutProcessor{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger){
        $this->logger = $logger;
    }

    /**
     * @param LayoutProcessorSubject $subject
     * @param $jsLayout
     * @return array
     */
    public function afterProcess(LayoutProcessorSubject $subject, $jsLayout) {

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['street']['children'][0]['label'] = 'Calle y No.:';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['street']['children'][1]['label'] = 'Colonia:';

        return $jsLayout;
    }

}
