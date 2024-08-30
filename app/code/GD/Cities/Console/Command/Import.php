<?php
namespace GD\Cities\Console\Command;

use GD\Cities\Helper\Data as DataHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Import extends Command
{
    /**
     * @var DataHelper
     */
    public $helper;

    public function __construct(DataHelper $helper)
    {
        parent::__construct();
        $this->helper = $helper;
    }

    protected function configure()
    {
        $this->setName('gd:cities:import');
        $this->setDescription('Manual Process to Import Cities');
        //parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->helper->importProcess();
        return Command::SUCCESS;
    }

}
