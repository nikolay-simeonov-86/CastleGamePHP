<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ArmyStatistics;
use AppBundle\Entity\BuildingUpdateProperties;
use AppBundle\Entity\Castle;
use AppBundle\Entity\User;
use AppBundle\Entity\UserUpdateResources;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\ArmyStatisticsService;
use AppBundle\Service\BuildingUpdatePropertiesService;
use AppBundle\Service\CastleServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ArmyStatisticsService
     */
    private $armyStatisticsService;

    /**
     * @var CastleServiceInterface
     */
    private $castleService;

    /**
     * @var BuildingUpdatePropertiesService
     */
    private $buildingUpdatePropertiesService;

    /**
     * UserService constructor.
     * @param EntityManagerInterface $em
     * @param UserRepository $userRepository
     * @param ArmyStatisticsService $armyStatisticsService
     * @param CastleServiceInterface $castleService
     * @param BuildingUpdatePropertiesService $buildingUpdatePropertiesService
     */
    public function __construct(EntityManagerInterface $em,
                                UserRepository $userRepository,
                                ArmyStatisticsService $armyStatisticsService,
                                CastleServiceInterface $castleService,
                                BuildingUpdatePropertiesService $buildingUpdatePropertiesService)
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->armyStatisticsService = $armyStatisticsService;
        $this->castleService = $castleService;
        $this->buildingUpdatePropertiesService = $buildingUpdatePropertiesService;
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     */
    public function indexAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('user');
        }
        if (null == $this->em->getRepository(ArmyStatistics::class)->findAll())
        {
            $this->armyStatisticsService->createArmyStatistics();
        }
        if (null == $this->em->getRepository(BuildingUpdateProperties::class)->findAll())
        {
            $this->buildingUpdatePropertiesService->createBuildingUpdateProperties();
        }
        return $this->render('view/home.html.twig');
    }

    /**
     * @Route("/test", name="view_test_template")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function baseTemplateAction(Request $request)
    {
        $currentDateTime = new \DateTime("now + 60 minutes");
        $user = $this->getUser();
            $foodUser = 0;
            $food = $user->getFood();
            $metal = $user->getMetal();
            $userUpdateResources = $this->em->getRepository(UserUpdateResources::class)->findOneBy(array('userId' => $user->getId()));
            $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $user->getId()));
            foreach ($castles as  $castle)
            {
                $tempInterval = date_diff($userUpdateResources->getLastUpdateDate(), $currentDateTime);
                $interval = $tempInterval->format("%y %m %d %h %i %s");
                list($year, $month, $day, $hour, $minute, $second) = array_map('intval', explode(' ', $interval));
                $minutes = (int)floor((($year * 365.25 + $month * 30 + $day) * 24 + $hour) * 60 + $minute + $second/60);
                if ($minutes > 1)
                {
                    if ($castle->getMineFoodLvl() == 0)
                    {
                        $foodTemp = 0;
                    }
                    elseif ($castle->getMineFoodLvl() == 1)
                    {
                        $foodTemp = $minutes*1;
                    }
                    elseif ($castle->getMineFoodLvl() == 2)
                    {
                        $foodTemp = $minutes*2;
                    }
                    elseif ($castle->getMineFoodLvl() == 3)
                    {
                        $foodTemp = $minutes*5;
                    }

                    if ($castle->getMineMetalLvl() == 0)
                    {
                        $metalTemp = 0;
                    }
                    elseif ($castle->getMineMetalLvl() == 1)
                    {
                        $metalTemp = $minutes*1;
                    }
                    elseif ($castle->getMineMetalLvl() == 2)
                    {
                        $metalTemp = $minutes*2;
                    }
                    elseif ($castle->getMineMetalLvl() == 3)
                    {
                        $metalTemp = $minutes*3;
                    }
                }
                $foodUser = $foodUser+$foodTemp;
                dump($foodTemp);
            }
            dump($minutes);
            dump($foodUser);
            die();

        return $this->render('view/test.html.twig', array('users' => $users));
    }
}
