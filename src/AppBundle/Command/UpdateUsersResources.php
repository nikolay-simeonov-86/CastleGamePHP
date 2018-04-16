<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 9.2.2018 г.
 * Time: 15:24 ч.
 */

namespace AppBundle\Command;


use AppBundle\Service\UserUpdateResourcesServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateUsersResources extends Command
{
    /**
     * @var UserUpdateResourcesServiceInterface
     */
    private $userUpdateResourcesService;

    public function __construct(UserUpdateResourcesServiceInterface $userUpdateResourcesService, $name = null)
    {
        $this->userUpdateResourcesService = $userUpdateResourcesService;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('game:users:resources:update');
        $this->setDescription('This function updates all users resources');
        $this->setHelp('The function calculates how many resources each user has made from the last time the same function was called until now.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->userUpdateResourcesService->updateUsersResources();

        $output->writeln("All users resources are updated.");
    }
}