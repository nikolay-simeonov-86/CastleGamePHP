<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ArmyStatistics;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\ArmyStatisticsService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $em
     * @param ArmyStatisticsService $armyStatisticsService
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $em, ArmyStatisticsService $armyStatisticsService)
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->armyStatisticsService = $armyStatisticsService;
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
        return $this->render('view/home.html.twig');
    }

    /**
     * @Route("/test", name="view_test_template")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function baseTemplateAction()
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
//        dump($castles);
//        die();
        return $this->render('view/test.html.twig', array('users' => $users, 'castles' => $castles));
    }
}
