<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ArmyStatistics;
use AppBundle\Entity\BuildingUpdateProperties;
use AppBundle\Entity\NewCastleCost;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\ArmyStatisticsService;
use AppBundle\Service\BattleReportsServiceInterface;
use AppBundle\Service\BattlesServiceInterface;
use AppBundle\Service\BuildingUpdatePropertiesService;
use AppBundle\Service\CastleServiceInterface;
use AppBundle\Service\NewCastleCostServiceInterface;
use AppBundle\Service\UserMessagesService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends BaseController
{
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
        if (null == $this->em->getRepository(NewCastleCost::class)->findAll())
        {
            $this->newCastleCostService->createNewCastleCost();
        }

        return $this->render('view/home.html.twig');
    }

    /**
     * @Route("/introduction", name="introduction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function introductionAction()
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $user = $this->getUser();
            $this->updateUserMessageNotifications($user);
        }

        return $this->render('view/introduction.html.twig');
    }

    /**
     * @Route("/test", name="view_test_template")
     * @param Request $request
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function baseTemplateAction(Request $request, bool $success = false)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $this->battlesService->battleCalculationAndArmyReturn();

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

        $success = true;
        return $this->render('view/test.html.twig', array('finalTableArrayResult'=>$finalTableArrayResult,
                                                      'totalPages'=>$totalPages,
                                                      'currentPage'=> $page,
                                                      'success' => $success));
    }
}
