<?php
namespace GD\Cities\Setup\Patch\Data;
use GD\Cities\Helper\Data as DataHelper;
use Magento\Framework\App\State;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;


class DistricsImport implements DataPatchInterface{

    /**
     * @var ModuleDataSetupInterface
     */
    protected ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var DataHelper
     */
    protected DataHelper $dataHelper;

    /**
     * @var State
     */
    private $state;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param DataHelper $dataHelper
     */
    public function __construct(ModuleDataSetupInterface $moduleDataSetup,
                                State $appState,
                                DataHelper $dataHelper){
        $this->moduleDataSetup = $moduleDataSetup;
        $this->state = $appState;
        $this->dataHelper = $dataHelper;

    }

    /**
     * @return array|string[]
     */
    public static function getDependencies(){
        return [];
    }

    /**
     * @return array|string[]
     */
    public function getAliases(){
        return [];
    }

    /**
     * @return void
     */
    public function apply(){
        $this->moduleDataSetup->startSetup();
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
        $this->dataHelper->importProcess();
        $this->moduleDataSetup->endSetup();
    }

}
