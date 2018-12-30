<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\DefaultController;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DefaultControllerTest extends KernelTestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * DefaultControllerTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $kernel = self::bootKernel();
        $this->container = $kernel->getContainer();
    }

    public function testController()
    {
        $defaultController = $this->container->get(DefaultController::class);

        $response = new \Symfony\Component\HttpFoundation\Response();

        $this->assertInstanceOf($response, $defaultController->introductionAction());
    }
}