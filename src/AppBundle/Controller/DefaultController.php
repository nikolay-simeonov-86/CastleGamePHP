<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ArmyStatistics;
use AppBundle\Entity\BuildingUpdateProperties;
use AppBundle\Entity\User;
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
        $userId = $this->getUser()->getId();
        $query = $this->em->createQuery('SELECT u FROM AppBundle\Entity\User u WHERE u.id = ?1');
        $query->setParameter(1, $userId);
        $users = $query->getResult();
        $query = $this->em->createQuery('SELECT partial c.{id, name, armyLvl1Building, armyLvl2Building, armyLvl3Building, castleLvl, mineFoodLvl, mineMetalLvl, resourceFood, resourceMetal, castlePicture} 
                                              FROM AppBundle\Entity\Castle c 
                                              WHERE c.userId = ?1');
        $query->setParameter(1, $userId);
        $castles = $query->getResult();

        $form = $this->createFormBuilder()->add('create', SubmitType::class)->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $castleName = 'Dwarf';
            $user = $this->getUser();
            $this->castleService->buildNewCastle($user, $castleName);
            return $this->redirectToRoute('user_castles');
        }

//        dump($castles);
//        die();
        return $this->render('view/test.html.twig', array('form' => $form->createView(), 'users' => $users, 'castles' => $castles));
    }
}
