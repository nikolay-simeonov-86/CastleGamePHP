<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ArmyStatistics;
use AppBundle\Entity\ArmyTrainTimers;
use AppBundle\Entity\BuildingUpdateProperties;
use AppBundle\Entity\Castle;
use AppBundle\Entity\User;
use AppBundle\Entity\UserUpdateResources;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\ArmyStatisticsService;
use AppBundle\Service\BuildingUpdatePropertiesService;
use AppBundle\Service\CastleServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
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
        $page = $request->get('page');
        $countPerPage = 6;

        $countQuery = $this->em->createQueryBuilder()
            ->select('Count(DISTINCT u.id)')
            ->from('AppBundle:ArmyTrainTimers', 'u');
        $finalCountQuery = $countQuery->getQuery();
        try {
            $totalCount = $finalCountQuery->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            $totalCount = 0;
        }

        if ($totalCount>0)
        {
            $totalPages=ceil($totalCount/$countPerPage);

            if(!is_numeric($page)){
                $page=1;
            }
            else{
                $page=floor($page);
            }
            if($totalCount<=$countPerPage){
                $page=1;
            }
            if(($page*$countPerPage)>$totalCount){
                $page=$totalPages;
            }
            $offset=0;
            if($page>1){
                $offset = $countPerPage * ($page-1);
            }
            $visualQuery = $this->em->createQueryBuilder()
                ->select('u.id, COUNT(u.armyType), MAX(u.finishTime), u.trainAmount')
                ->from('AppBundle:ArmyTrainTimers', 'u')
                ->groupBy('u.trainAmount')
                ->orderBy('u.finishTime', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($countPerPage);
            $visualFinalQuery = $visualQuery->getQuery();
            $finalTableArrayResult = $visualFinalQuery->getArrayResult();
        }
        else
        {
            $finalTableArrayResult = [];
            $totalPages = 0;
        }

        return $this->render('view/test.html.twig', array('finalTableArrayResult'=>$finalTableArrayResult,
                                                      'totalPages'=>$totalPages,
                                                      'currentPage'=> $page));
    }
}
