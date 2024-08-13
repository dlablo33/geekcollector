<?php

namespace GD\Installers\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;

class GeneralConfig implements DataPatchInterface{

    /**
     * @var ModuleDataSetupInterface
     */
    protected ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    protected \Magento\Framework\App\Config\Storage\WriterInterface $configWriter;


    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param WriterInterface $configWriter
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->configWriter = $configWriter;
    }

    public static function getDependencies(){
        return [];
    }

    public function getAliases(){
        return [];
    }

    public function apply(){

        $this->moduleDataSetup->startSetup();
        $this->configWriter->save('general/locale/timezone', 'America/Monterrey', 'default', 0);
        $this->configWriter->save('currency/options/base', 'MXN', 'default', 0);
        $this->configWriter->save('currency/options/default', 'MXN', 'default', 0);
        $this->configWriter->save('currency/options/allow', 'MXN', 'default', 0);
        $this->configWriter->save('analytics/subscription/enabled', 'MX', 'default', 0);

        $this->configWriter->save('general/country/allow', 'MX', 'default', 0);
        $this->configWriter->save('general/country/optional_zip_countries', 'MX', 'default', 0);
        $this->configWriter->save('general/country/eu_countries', 'MX', 'default', 0);
        $this->configWriter->save('general/country/destinations', 'MX', 'default', 0);
        $this->configWriter->save('general/locale/weight_unit', 'kgs', 'default', 0);

        $this->configWriter->save('general/locale/firstday', '1', 'default', 0);
        $this->configWriter->save('general/locale/weekend', '0,6', 'default', 0);

        $this->configWriter->save('tax/defaults/country', 'MX', 'default', 0);
        $this->configWriter->save('tax/calculation/price_includes_tax', '0', 'default', 0);
        $this->configWriter->save('tax/calculation/apply_tax_on', '1', 'default', 0);

        $this->moduleDataSetup->endSetup();
    }

}
