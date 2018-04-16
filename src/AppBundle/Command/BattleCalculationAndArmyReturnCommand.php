<?php

namespace AppBundle\Command;

use AppBundle\Service\BattlesServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BattleCalculationAndArmyReturnCommand extends Command
{
    /**
     * @var BattlesServiceInterface
     */
    private $battlesService;

    public function __construct(BattlesServiceInterface $battlesService, $name = null)
    {
        $this->battlesService = $battlesService;
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('game:users:battles:update');
        $this->setDescription('This function initiates all users battles and return surviving army');
        $this->setHelp('The function initiates all battles that have reached their target and returns the surviving army to their castle.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->battlesService->battleCalculationAndArmyReturn();

        $output->writeln("Battles are completed and remaining army is returned.");
    }
}
