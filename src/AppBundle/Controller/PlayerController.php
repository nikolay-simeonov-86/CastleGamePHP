<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Army;
use AppBundle\Entity\ArmyBattles;
use AppBundle\Entity\ArmyStatistics;
use AppBundle\Entity\ArmyTrainTimers;
use AppBundle\Entity\BattleReports;
use AppBundle\Entity\Battles;
use AppBundle\Entity\BattlesTemp;
use AppBundle\Entity\BuildingUpdateProperties;
use AppBundle\Entity\BuildingUpdateTimers;
use AppBundle\Entity\Castle;
use AppBundle\Entity\NewCastleCost;
use AppBundle\Entity\User;
use AppBundle\Entity\UserMessages;
use AppBundle\Entity\UserSpies;
use AppBundle\Service\ArmyServiceInterface;
use AppBundle\Service\ArmyStatisticsServiceInterface;
use AppBundle\Service\ArmyTrainTimersServiceInterface;
use AppBundle\Service\BattleReportsServiceInterface;
use AppBundle\Service\BattlesServiceInterface;
use AppBundle\Service\BattlesTempService;
use AppBundle\Service\BattlesTempServiceInterface;
use AppBundle\Service\CastleServiceInterface;
use AppBundle\Service\NewCastleCostServiceInterface;
use AppBundle\Service\UserMessagesServiceInterface;
use AppBundle\Service\UserServiceInterface;
use AppBundle\Service\UserSpiesServiceInterface;
use AppBundle\Service\UserUpdateResourcesServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class PlayerController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var CastleServiceInterface
     */
    private $castleService;

    /**
     * @var ArmyServiceInterface
     */
    private $armyService;

    /**
     * @var ArmyTrainTimersServiceInterface
     */
    private $armyTrainTimersService;

    /**
     * @var ArmyStatisticsServiceInterface
     */
    private $armyStatisticsService;

    /**
     * @var UserSpiesServiceInterface
     */
    private $userSpiesService;

    /**
     * @var UserUpdateResourcesServiceInterface
     */
    private $userUpdateResourcesService;

    /**
     * @var UserMessagesServiceInterface
     */
    private $userMessagesService;

    /**
     * @var BattlesServiceInterface
     */
    private $battlesService;

    /**
     * @var BattlesTempServiceInterface
     */
    private $battlesTempService;

    /**
     * @var BattleReportsServiceInterface
     */
    private $battleReportsService;

    /**
     * @var NewCastleCostServiceInterface
     */
    private $newCastleCostService;

    /**
     * CastleController constructor.
     * @param UserServiceInterface $userService
     * @param CastleServiceInterface $castleService
     * @param ArmyServiceInterface $armyService
     * @param EntityManagerInterface $em
     * @param ArmyTrainTimersServiceInterface $armyTrainTimersService
     * @param ArmyStatisticsServiceInterface $armyStatisticsService
     * @param UserSpiesServiceInterface $userSpiesService
     * @param UserUpdateResourcesServiceInterface $userUpdateResourcesService
     * @param UserMessagesServiceInterface $userMessagesService
     * @param BattlesServiceInterface $battlesService
     * @param BattlesTempService $battlesTempService
     * @param BattleReportsServiceInterface $battleReportsService
     * @param NewCastleCostServiceInterface $newCastleCostService
     */
    public function __construct(UserServiceInterface $userService,
                                CastleServiceInterface $castleService,
                                ArmyServiceInterface $armyService,
                                EntityManagerInterface $em,
                                ArmyTrainTimersServiceInterface $armyTrainTimersService,
                                ArmyStatisticsServiceInterface $armyStatisticsService,
                                UserSpiesServiceInterface $userSpiesService,
                                UserUpdateResourcesServiceInterface $userUpdateResourcesService,
                                UserMessagesServiceInterface $userMessagesService,
                                BattlesServiceInterface $battlesService,
                                BattlesTempService $battlesTempService,
                                BattleReportsServiceInterface $battleReportsService,
                                NewCastleCostServiceInterface $newCastleCostService)
    {
        $this->em = $em;
        $this->userService = $userService;
        $this->castleService = $castleService;
        $this->armyService = $armyService;
        $this->armyTrainTimersService = $armyTrainTimersService;
        $this->armyStatisticsService = $armyStatisticsService;
        $this->userSpiesService = $userSpiesService;
        $this->userUpdateResourcesService = $userUpdateResourcesService;
        $this->userMessagesService = $userMessagesService;
        $this->battlesService = $battlesService;
        $this->battlesTempService = $battlesTempService;
        $this->battleReportsService = $battleReportsService;
        $this->newCastleCostService = $newCastleCostService;
    }

    /**
     * @Route("/logged_user/{success}", name="user")
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userHomepageAction(bool $success = false)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $userId = $user->getId();

//        $this->userUpdateResourcesService->updateUsersResources();

        $newCastleCostsArray = $this->em->getRepository(NewCastleCost::class)->findAll();
        list($newCastleCosts) = $newCastleCostsArray;

        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));
        foreach ($castles as $castle)
        {
            $this->castleService->updateCastle($castle->getId());
        }

        return $this->render( 'view/user.html.twig', array('castles' => $castles, 'user' => $user, 'newCastleCosts' => $newCastleCosts, 'success' => $success));
    }

    /**
     * @Route("/user/buy/castle", name="user_buy_castle")
     * @param Request $request
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBuyNewCastle(Request $request)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $userId = $user->getId();
        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));

        $form = $this->createFormBuilder()
            ->add('Select', ChoiceType::class,
                array(
                    'mapped' => false,
                    'choices'  =>
                        array(
                            'Dark' =>
                                array(
                                    'Dwarf' => 'Dwarf',
                                    'Ninja' => 'Ninja',
                                    'Vampire' => 'Vampire'
                                ),
                            'Light' =>
                                array(
                                    'Elfs' => 'Elfs',
                                    'Mages' => 'Mages',
                                    'Olymp' => 'Olymp'
                                ),
                        ),
                )
            )
            ->add('Confirm', SubmitType::class,
                array('attr' => array('type' => 'button', 'class' => 'btn btn-lg btn-success bodytext cursor-pointer send-a-message-button')))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $message = $this->newCastleCostService->calculateCostForNewCastle($user);

            if ($message)
            {
                return $this->render('view/user_buy_castle.html.twig', array('form' => $form->createView(),
                                                                                    'castles' => $castles,
                                                                                    'message' => $message));
            }
            else
            {
                $this->newCastleCostService->buildNewCastle($user, $form->get('Select')->getData());
                $success = true;
                return $this->redirectToRoute('user', array('success' => $success));
            }
        }

        return $this->render('view/user_buy_castle.html.twig', array('form' => $form->createView(),
                                                                            'castles' => $castles));
    }

    /**
     * @Route("/user/{id}", name="user_profile")
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userProfileAction(int $id, Request $request)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

//        $this->userUpdateResourcesService->updateUsersResources();

        if ($this->getUser()->getId() === $id)
        {
            return $this->redirectToRoute('user');
        }

        if ($this->em->getRepository(User::class)->find($id))
        {
            $user = $this->em->getRepository(User::class)->find($id);
            $userId = $user->getId();
        }
        else
        {
            return $this->redirectToRoute('map');
        }

        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));
        $count = 0;
        foreach ($castles as $castle)
        {
            if ($count == 0)
            {
                $mainCastleId = $castle->getId();
            }
            $this->castleService->updateCastle($castle->getId());
            $count++;
        }

        $loggedUser = $this->getUser();
        $this->userSpiesService->expireUserSpy($loggedUser);

        $form = $this->createFormBuilder()->add('spy', SubmitType::class)->getForm();
        $form->handleRequest($request);

        if ($this->em->getRepository(UserSpies::class)->findOneBy(array('userId' => $loggedUser, 'targetUserId' => $id)))
        {
            $userSpyCheck = $this->em->getRepository(UserSpies::class)->findOneBy(array('userId' => $loggedUser, 'targetUserId' => $id));
            $currentDateTime = new \DateTime("now");

            if ($userSpyCheck->getStartDate() < $currentDateTime)
            {
                $tempInterval = date_diff($userSpyCheck->getExpirationDate(), $currentDateTime);
                $interval = $tempInterval->format('%I minutes');
                $armyAll = $this->em->getRepository(Army::class)->findBy(array('castleId' => $mainCastleId));
                return $this->render( 'view/user_profile.html.twig', array('form' => $form->createView(),
                                                                        'castles' => $castles,
                                                                        'user' => $user,
                                                                        'interval' => $interval,
                                                                        'armyAll' => $armyAll));
            }
            else
            {
                $tempInterval = date_diff($userSpyCheck->getStartDate(), $currentDateTime);
                $timeLeft = $tempInterval->format('%H hours and %I minutes');
                return $this->render( 'view/user_profile.html.twig', array('form' => $form->createView(),
                                                                        'castles' => $castles,
                                                                        'user' => $user,
                                                                        'timeLeft' => $timeLeft));
            }
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            $message = $this->userSpiesService->purchaseUserSpy($loggedUser);
            if ($message)
            {
                return $this->render( 'view/user_profile.html.twig', array('form' => $form->createView(),
                                                                        'castles' => $castles,
                                                                        'user' => $user,
                                                                        'message' => $message));
            }
            $this->userSpiesService->createUserSpy($loggedUser, $id);

            return $this->redirectToRoute('user_profile', array('id' => $id));
        }

        return $this->render( 'view/user_profile.html.twig', array('form' => $form->createView(),
                                                                'castles' => $castles,
                                                                'user' => $user));
    }

    /**
     * @Route("/map", name="map")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     */
    public function viewMapAction()
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $user = $this->getUser();
            $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
            $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
            $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
            $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);
        }

        $query = $this->em->createQuery('SELECT u.id, u.username, u.coordinates, u.castleIcon 
                                              FROM AppBundle\Entity\User u');
        $users = $query->getResult();

        return $this->render('view/map.html.twig', array('users' => $users));
    }

    /**
     * @Route("/castles/{success}", name="user_castles")
     * @param Request $request
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userCastlesAction(Request $request, bool $success = false)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $userId = $this->getUser()->getId();
        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));
        $currentDateTime = new \DateTime("now");
        $timeRemaining = array();
        $allUpdates = array();
        foreach ($castles as $castle)
        {
            $this->castleService->updateCastle($castle->getId());

            $updates = $this->em->getRepository(BuildingUpdateTimers::class)->findBy(array('castleId' => $castle->getId()));

            if ($updates)
            {
                foreach ($updates as $update)
                {
                    $tempInterval = date_diff($update->getFinishTime(), $currentDateTime);
                    $interval = $tempInterval->format('%H hours and %I minutes');
                    $allUpdates[] = $update;
                    $temp['id'] = $update->getId();
                    $temp['building'] = $update->getBuilding();
                    $temp['timeRemaining'] = $interval;
                    $timeRemaining[] = $temp;
                }
            }
        }
        return $this->render('view/castles.html.twig', array('castles' => $castles, 'allUpdates' => $allUpdates, 'timeRemaining' => $timeRemaining, 'success' => $success));
    }

    /**
     * @Route("/upgrade/{id}/{building}", name="upgrade")
     * @param string $building
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     * @throws \Exception
     */
    public function userUpgradeAction(int $id,string $building, Request $request)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $form = $this->createFormBuilder()->add('upgrade', SubmitType::class)->getForm();
        $form->handleRequest($request);

        $castle = $this->em->getRepository(Castle::class)->find($id);
        $this->castleService->updateCastle($castle->getId());

        $buildingUpdate = $this->em->getRepository(BuildingUpdateProperties::class)->findOneBy(array('name' => $building));

        $costsArray = $this->castleService->purchaseBuildingCost($building, $castle, $buildingUpdate);
        list($foodCost, $metalCost, $updateTimer) = $costsArray;

        if (null == $castle)
        {
            throw $this->createNotFoundException('No castle found for id ' . $id);
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            try
            {
                $updates = $this->em->getRepository(BuildingUpdateTimers::class)->findBy(array('castleId' => $castle->getId()));

                foreach ($updates as $update)
                {
                    if ($castle->getId() == $update->getCastleId()->getId() && $update->getBuilding() == $building)
                    {
                        throw $exception = new Exception('Upgrade in progress');
                    }
                }
            }
            catch (Exception $exception)
            {
                $message = $exception->getMessage();
                return $this->render('view/upgrade.html.twig', array('form' => $form->createView(),
                                                                            'building' => $building,
                                                                            'foodCost' => $foodCost,
                                                                            'metalCost' => $metalCost,
                                                                            'updateTimer' => $updateTimer,
                                                                            'message' => $message));
            }
            $message = $this->castleService->purchaseBuilding($building, $user, $castle, $buildingUpdate);

            if ($message)
            {
                return $this->render('view/upgrade.html.twig', array('form' => $form->createView(),
                                                                            'building' => $building,
                                                                            'foodCost' => $foodCost,
                                                                            'metalCost' => $metalCost,
                                                                            'updateTimer' => $updateTimer,
                                                                            'message' => $message));
            }
            $success = true;
            return $this->redirectToRoute('user_castles', array('success' => $success));
        }
        return $this->render('view/upgrade.html.twig', array('form' => $form->createView(),
                                                                    'building' => $building,
                                                                    'foodCost' => $foodCost,
                                                                    'metalCost' => $metalCost,
                                                                    'updateTimer' => $updateTimer));
    }

    /**
     * @Route("/army/{success}", name="user_army")
     * @param Request $request
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userArmyAction(Request $request, bool $success = false)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $userId = $this->getUser()->getId();

        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));
        $allArmy = [];
        foreach ($castles as $castle)
        {
            $this->castleService->updateCastle($castle->getId());
            $armyTemp = $this->em->getRepository(Army::class)->findBy(array('castleId' => $castle->getId()));

            if ($armyTemp)
            {
                foreach ($armyTemp as $army)
                {
                    $this->armyService->updateArmy($army->getId());
                    if ($army->getAmount() == 0)
                    {
                        $this->em->remove($army);
                        $this->em->flush();
                    }
                    $allArmy[] = $army;
                }
            }
        }
        uasort($allArmy, function($a,$b){
            $c = strcmp($a->getName(), $b->getName());
            $c .= $a->getLevel() - $b->getLevel();
            return $c;
        });

        return $this->render('view/army.html.twig', array('castles' => $castles, 'allArmy' => $allArmy, 'success' => $success));
    }

    /**
     * @Route("/train_army/{id}/{army}", name="train_army")
     * @param string $army
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     * @throws \Exception
     */
    public function userTrainArmyAction(int $id, string $army, Request $request)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $castle = $this->em->getRepository(Castle::class)->find($id);
        $currentDateTime = new \DateTime("now");

        $prizes = $this->armyStatisticsService->armyCostForOneUnit($castle, $army);
        list($foodCostForOne, $metalCostForOne, $level) = $prizes;

        if ($this->em->getRepository(Army::class)->findOneBy(array('name' => $army, 'level' => $level, 'castleId' => $castle)))
        {
            $armyTemp = $this->em->getRepository(Army::class)->findOneBy(array('name' => $army, 'level' => $level, 'castleId' => $castle));
            $this->armyService->updateArmy($armyTemp->getId());

            $armyVisualizeTemp = $this->em->getRepository(ArmyTrainTimers::class)->findBy(array('armyId' => $armyTemp, 'armyType' => $army));
            $armyVisualize = [];
            $counter = 0;
            foreach ($armyVisualizeTemp as $armyVisualizeOne)
            {
                $tempInterval = date_diff($armyVisualizeOne->getFinishTime(), $currentDateTime);
                $interval = $tempInterval->format('%D days %H hours and %I minutes');
                $armyVisualizeTemp1[] = $armyVisualizeOne;
                $temp['armyType'] = $armyVisualizeOne->getArmyType();
                $temp['trainAmount'] = $armyVisualizeOne->getTrainAmount();
                $temp['timeRemaining'] = $interval;
                $armyVisualize[] = $temp;
                $counter++;
            }
        }
        else
        {
            $armyVisualize = [];
            $counter = 0;
        }

        $userFood = $this->getUser()->getFood();
        $userMetal = $this->getUser()->getMetal();

        $maxAmount = $this->armyService->maximumArmyAmountToTrain($userFood, $userMetal, $army, $level);

        $form = $this->createFormBuilder()->add('Amount', IntegerType::class, array('attr' =>
                                                                                            array('value' => 1,
                                                                                                  'min' => 1,
                                                                                                  'max' => $maxAmount)))
                                            ->add('Train', SubmitType::class)->getForm();
        $form->handleRequest($request);

        try
        {
            if ($counter >= 5)
            {
                throw $exception = new Exception('You can only train 5 groups at once');
            }
        }
        catch (\Exception $exception)
        {
            $message = $exception->getMessage();
            return $this->render('view/train_army.html.twig', array('form' => $form->createView(),
                                                                'army' => $army,
                                                                'maxAmount' => $maxAmount,
                                                                'armyVisualize' => $armyVisualize,
                                                                'foodCostForOne' => $foodCostForOne,
                                                                'metalCostForOne' => $metalCostForOne,
                                                                'message' => $message));
        }
        if ($form->isSubmitted() && $form->isValid())
        {
            try
            {
                if ($form->get('Amount')->getData() > $maxAmount)
                {
                    throw $exception = new Exception('Not enough resources to train this many units');
                }
                if ($form->get('Amount')->getData() == 0)
                {
                    throw $exception = new Exception('Invalid input');
                }
            }
            catch (\Exception $exception)
            {
                $message = $exception->getMessage();
                return $this->render('view/train_army.html.twig', array('form' => $form->createView(),
                                                                    'army' => $army,
                                                                    'maxAmount' => $maxAmount,
                                                                    'foodCostForOne' => $foodCostForOne,
                                                                    'metalCostForOne' => $metalCostForOne,
                                                                    'message' => $message));
            }
            return $this->redirectToRoute('confirm_train_army', array('army' => $army,
                                                                            'id' => $id,
                                                                            'amount' => $form->get('Amount')->getData()));
        }

        return $this->render('view/train_army.html.twig', array('form' => $form->createView(),
                                                            'army' => $army,
                                                            'maxAmount' => $maxAmount,
                                                            'foodCostForOne' => $foodCostForOne,
                                                            'metalCostForOne' => $metalCostForOne,
                                                            'armyVisualize' => $armyVisualize));
    }

    /**
     * @Route("/confirm_train_army/{id}/{army}/{amount}", name="confirm_train_army")
     * @param int $id
     * @param string $army
     * @param int $amount
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userConfirmTrainArmyAction(int $id, string $army, int $amount, Request $request)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $form = $this->createFormBuilder()->add('Confirm', SubmitType::class)->getForm();
        $form->handleRequest($request);

        $castle = $this->em->getRepository(Castle::class)->find($id);

        if ($army == 'Footmen')
        {
            $level = $castle->getArmyLvl1Building();
        }
        elseif ($army == 'Archers')
        {
            $level = $castle->getArmyLvl2Building();
        }
        elseif ($army == 'Cavalry')
        {
            $level = $castle->getArmyLvl3Building();
        }

        $result = $this->armyStatisticsService->armyCostAndTimeToTrain($army, $level, $amount);
        list($prizeFood, $prizeMetal, $trainTime) = $result;

        if ($this->em->getRepository(Army::class)->findOneBy(array('name' => $army, 'level' => $level, 'castleId' => $castle)))
        {
            $armyTemp = $this->em->getRepository(Army::class)->findOneBy(array('name' => $army, 'level' => $level, 'castleId' => $castle));
            $this->armyService->updateArmy($armyTemp->getId());

            $counter = count($this->em->getRepository(ArmyTrainTimers::class)->findBy(array('armyId' => $armyTemp, 'armyType' => $army)));
        }
        else
        {
            $counter = 0;
        }

        try
        {
            if ($counter >= 5)
            {
                throw $exception = new Exception('You can only train 5 groups at once');
            }
        }
        catch (\Exception $exception)
        {
            $message = $exception->getMessage();
            return $this->render('view/confirm_train_army.html.twig', array('form' => $form->createView(),
                                                                        'amount' => $amount,
                                                                        'army' => $army,
                                                                        'prizeFood' => $prizeFood,
                                                                        'prizeMetal' => $prizeMetal,
                                                                        'trainTime' => $trainTime,
                                                                        'id' => $id,
                                                                        'message' => $message));
        }
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->armyTrainTimersService->createArmyTrainTimer($army, $castle, $amount, $id);

            $user = $this->getUser();
            $message = $this->armyService->trainArmyUserPayment($user, $prizeFood, $prizeMetal);

            if ($message)
            {
                return $this->render('view/confirm_train_army.html.twig', array('form' => $form->createView(),
                                                                            'amount' => $amount,
                                                                            'army' => $army,
                                                                            'prizeFood' => $prizeFood,
                                                                            'prizeMetal' => $prizeMetal,
                                                                            'trainTime' => $trainTime,
                                                                            'id' => $id,
                                                                            'message' => $message));
            }
            $success = true;
            return $this->redirectToRoute('user_army', array('success' => $success));
        }
        return $this->render('view/confirm_train_army.html.twig', array('form' => $form->createView(),
                                                                    'amount' => $amount,
                                                                    'army' => $army,
                                                                    'prizeFood' => $prizeFood,
                                                                    'prizeMetal' => $prizeMetal,
                                                                    'trainTime' => $trainTime,
                                                                    'id' => $id));
    }

    /**
     * @Route("/messages/inbox/{page}/{success}", name="user_messages_inbox")
     * @param int $page
     * @param Request $request
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userMessagesInboxAction($page = 0, Request $request, bool $success = false)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $countPerPage = 8;

        $countQuery = $this->em->createQueryBuilder()
            ->select('Count(DISTINCT u.senderUsername)')
            ->from('AppBundle:UserMessages', 'u')
            ->where('u.userId = ?1')
            ->setParameter(1, $user);
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
                ->select('DISTINCT(u.senderUsername), COUNT(u.message), MAX(u.sentDate)')
                ->from('AppBundle:UserMessages', 'u')
                ->where('u.userId = ?1')
                ->groupBy('u.senderUsername')
                ->orderBy('u.sentDate', 'DESC')
                ->setParameter(1, $user)
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

        return $this->render('view/user_messages_inbox.html.twig', array('finalTableArrayResult'=>$finalTableArrayResult,
                                                                     'totalPages'=>$totalPages,
                                                                     'currentPage'=> $page,
                                                                     'success' => $success));
    }

    /**
     * @Route("/messages/inbox/sender/{sender}/{page}/{success}", name="user_messages_inbox_sender")
     * @param string $sender
     * @param int $page
     * @param Request $request
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userMessagesInboxSenderAction(string $sender, $page = 0, Request $request, bool $success = false)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $countPerPage = 2;

        $countQuery = $this->em->createQueryBuilder()
            ->select('COUNT(u.message)')
            ->from('AppBundle:UserMessages', 'u')
            ->where('u.userId = ?1 AND u.senderUsername = ?2')
            ->setParameter(1, $user)
            ->setParameter(2, $sender);
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
                ->select('u.id, u.senderUsername, u.message, TRIM(u.sentDate)')
                ->from('AppBundle:UserMessages', 'u')
                ->where('u.userId = ?1 AND u.senderUsername = ?2')
                ->orderBy('u.sentDate', 'DESC')
                ->setParameter(1, $user)
                ->setParameter(2, $sender)
                ->setFirstResult($offset)
                ->setMaxResults($countPerPage);
            $visualFinalQuery = $visualQuery->getQuery();
            $finalTableArrayResult = $visualFinalQuery->getArrayResult();

            $sendersMessages = $this->em->getRepository(UserMessages::class)->findBy(array('userId' => $user, 'senderUsername' => $sender));
            foreach ($sendersMessages as $sendersMessage)
            {
                $sendersMessage->setVisited(true);
                $this->em->persist($sendersMessage);
                $this->em->flush();
            }
        }
        else
        {
            $finalTableArrayResult = [];
            $totalPages = 0;
        }

        return $this->render('view/user_messages_inbox_sender.html.twig', array('finalTableArrayResult'=>$finalTableArrayResult,
                                                                                    'totalPages'=>$totalPages,
                                                                                    'currentPage'=> $page,
                                                                                    'sender' => $sender,
                                                                                    'success' => $success));
    }

    /**
     * @Route("/messages/inbox/delete/{sender}/{page}/{id}", name="user_messages_inbox_sender_delete")
     * @param string $sender
     * @param int $page
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userMessagesInboxSenderDeleteAction(string $sender, int $page, int $id, Request $request)
    {
        $user = $this->getUser();
        $success = false;

        if (null == $this->em->getRepository(UserMessages::class)->findOneBy(array('id' => $id)))
        {
            return $this->redirectToRoute('user_messages_inbox_sender', array('sender' => $sender, 'page' => $page));
        }

        $message = $this->em->getRepository(UserMessages::class)->findOneBy(array('id' => $id));

        if ($message->getUserId() != $user)
        {
            return $this->redirectToRoute('user_messages_inbox_sender', array('sender' => $sender, 'page' => $page));
        }

        $this->em->remove($message);
        $this->em->flush();

        return $this->redirectToRoute('user_messages_inbox_sender', array('sender' => $sender, 'page' => $page));
    }

    /**
     * @Route("/messages/send/", name="user_messages_send")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userMessagesSendAction(Request $request)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $form = $this->createFormBuilder()
            ->add('receiver', TextType::class)
            ->add('message', TextareaType::class, array('attr' => array('class' => 'textarea', 'maxlength' => '250', 'rows' => '5', 'wrap' => 'hard', 'cols' => '50')))
            ->add('Send', SubmitType::class, array('attr' => array('type' => 'button', 'class' => 'btn btn-lg btn-success bodytext cursor-pointer send-a-message-button')))
            ->getForm();
        $form->handleRequest($request);

        $receiver = $form->get('receiver')->getData();
        $formMessage = trim(preg_replace('/\s+/', ' ', $form->get('message')->getData()));

        if ($form->isSubmitted() && $form->isValid())
        {
            $message = $this->userMessagesService->createNewMessage($user, $receiver, $formMessage);
            if ($message)
            {
                return $this->render('view/user_messages_send.html.twig', array('form' => $form->createView(),
                    'message' => $message));
            }
            else
            {
                $success = true;
                return $this->redirectToRoute('user_messages_inbox', array('success' => $success));
            }
        }
        return $this->render('view/user_messages_send.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/messages/send/{receiver}", name="user_messages_send_to_receiver")
     * @param string $receiver
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userMessagesSendToReceiverAction(string $receiver, Request $request)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $form = $this->createFormBuilder()
            ->add('message', TextareaType::class, array('attr' => array('class' => 'textarea', 'maxlength' => '250', 'rows' => '5', 'wrap' => 'hard', 'cols' => '50')))
            ->add('Send', SubmitType::class, array('attr' => array('type' => 'button', 'class' => 'btn btn-lg btn-success bodytext cursor-pointer send-a-message-button')))
            ->getForm();
        $form->handleRequest($request);

        $formMessage = trim(preg_replace('/\s+/', ' ', $form->get('message')->getData()));

        if ($form->isSubmitted() && $form->isValid())
        {
            $message = $this->userMessagesService->createNewMessage($user, $receiver, $formMessage);
            if ($message)
            {
                return $this->render('view/user_messages_send_to_receiver.html.twig', array('form' => $form->createView(),
                                                                                                    'message' => $message,
                                                                                                    'receiver' => $receiver));
            }
            else
            {
                $success = true;
                return $this->redirectToRoute('user_messages_inbox_sender', array('sender' => $receiver,
                                                                                        'page' => 1,
                                                                                        'success' => $success));
            }
        }
        return $this->render('view/user_messages_send_to_receiver.html.twig', array('form' => $form->createView(),
                                                                                'receiver' => $receiver));
    }

    /**
     * @Route("/battles{success}", name="user_battles")
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBattlesAction(bool $success = false)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        return $this->render('view/user_battles.html.twig', array('success' => $success));
    }

    /**
     * @Route("/battles/incoming", name="user_battles_incoming")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBattlesIncomingAction()
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $incomingAttacksArray = $this->battlesService->createAllUserArmyIncomingAttacksArray($user);

        return $this->render('view/user_battles_incoming.html.twig', array('incomingAttacks' => $incomingAttacksArray));
    }

    /**
     * @Route("/battles/outgoing", name="user_battles_outgoing")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBattlesOutgoingAction()
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $outgoingAttacksArray = $this->battlesService->createAllUserArmyOutgoingAttacksArray($user);

        return $this->render('view/user_battles_outgoing.html.twig', array('outgoingAttacks' => $outgoingAttacksArray));
    }

    /**
     * @Route("/battles/send_attack_castle", name="user_battles_send_attack_castle")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBattlesSendAttackCastleAction(Request $request)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $user));
        $allArmy = [];
        foreach ($castles as $castle)
        {
            $this->castleService->updateCastle($castle->getId());
            $armyTemp = $this->em->getRepository(Army::class)->findBy(array('castleId' => $castle->getId()));

            if ($armyTemp)
            {
                foreach ($armyTemp as $army)
                {
                    $this->armyService->updateArmy($army->getId());
                    $allArmy[] = $army;
                }
            }
        }
        uasort($allArmy, function($a,$b){
            $c = strcmp($a->getName(), $b->getName());
            $c .= $a->getLevel() - $b->getLevel();
            return $c;
        });

        return $this->render('view/user_battle_send_attack_castle.html.twig', array('castles' => $castles,
                                                                                'allArmy' => $allArmy));
    }

    /**
     * @Route("/battles/send_attack_army/{castleId}", name="user_battles_send_attack_army")
     * @param Request $request
     * @param int $castleId
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBattlesSendAttackArmyAction(Request $request, int $castleId)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $maxAmountArray = $this->armyService->maximumArmyAmountForBattle($castleId);
        list($maxAmountFootmenLvl1,
             $maxAmountFootmenLvl2,
             $maxAmountFootmenLvl3,
             $maxAmountArchersLvl1,
             $maxAmountArchersLvl2,
             $maxAmountArchersLvl3,
             $maxAmountCavalryLvl1,
             $maxAmountCavalryLvl2,
             $maxAmountCavalryLvl3) = $maxAmountArray;

        $form = $this->createFormBuilder()
            ->add('username', TextType::class, array('attr' =>
                array('class' => 'form-control text-center')))
            ->add('footmenLvl1', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountFootmenLvl1)))
            ->add('footmenLvl2', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountFootmenLvl2)))
            ->add('footmenLvl3', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountFootmenLvl3)))
            ->add('archersLvl1', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountArchersLvl1)))
            ->add('archersLvl2', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountArchersLvl2)))
            ->add('archersLvl3', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountArchersLvl3)))
            ->add('cavalryLvl1', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountCavalryLvl1)))
            ->add('cavalryLvl2', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountCavalryLvl2)))
            ->add('cavalryLvl3', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountCavalryLvl3)))
            ->add('Ready', SubmitType::class, array('attr' =>
                array('type' => 'button',
                    'class' => 'btn btn-lg btn-success bodytext cursor-pointer send-a-message-button')))
            ->getForm();
        $form->handleRequest($request);

        if (null == $this->em->getRepository(Castle::class)->findOneBy(array('id' => $castleId)))
        {
            return $this->redirectToRoute('user_battles_send_attack_castle');
        }
        $castle = $this->em->getRepository(Castle::class)->findOneBy(array('id' => $castleId));
        if ($castle->getUserId() != $user)
        {
            return $this->redirectToRoute('user_battles_send_attack_castle');
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            if (null == $this->em->getRepository(Castle::class)->findOneBy(array('id' => $castleId)))
            {
                return $this->redirectToRoute('user_battles_send_attack_castle');
            }
            $castle = $this->em->getRepository(Castle::class)->findOneBy(array('id' => $castleId));
            if ($castle->getUserId() != $user)
            {
                return $this->redirectToRoute('user_battles_send_attack_castle');
            }

            $message = $this->battlesTempService->createNewBattlesTemp($user, $form,
                                                                        $maxAmountFootmenLvl1,
                                                                        $maxAmountFootmenLvl2,
                                                                        $maxAmountFootmenLvl3,
                                                                        $maxAmountArchersLvl1,
                                                                        $maxAmountArchersLvl2,
                                                                        $maxAmountArchersLvl3,
                                                                        $maxAmountCavalryLvl1,
                                                                        $maxAmountCavalryLvl2,
                                                                        $maxAmountCavalryLvl3);

            if (is_string($message))
            {
                return $this->render('view/user_battle_send_attack_army.html.twig', array('form' => $form->createView(),
                                                                                    'maxAmountFootmenLvl1' => $maxAmountFootmenLvl1,
                                                                                    'maxAmountFootmenLvl2' => $maxAmountFootmenLvl2,
                                                                                    'maxAmountFootmenLvl3' => $maxAmountFootmenLvl3,
                                                                                    'maxAmountArchersLvl1' => $maxAmountArchersLvl1,
                                                                                    'maxAmountArchersLvl2' => $maxAmountArchersLvl2,
                                                                                    'maxAmountArchersLvl3' => $maxAmountArchersLvl3,
                                                                                    'maxAmountCavalryLvl1' => $maxAmountCavalryLvl1,
                                                                                    'maxAmountCavalryLvl2' => $maxAmountCavalryLvl2,
                                                                                    'maxAmountCavalryLvl3' => $maxAmountCavalryLvl3,
                                                                                    'message' => $message));
            }
            else
            {
                return $this->redirectToRoute('user_battles_send_attack_confirm', array('castleId' => $castleId, 'battleTempId' => $message));
            }
        }

        return $this->render('view/user_battle_send_attack_army.html.twig', array('form' => $form->createView(),
                                                                            'maxAmountFootmenLvl1' => $maxAmountFootmenLvl1,
                                                                            'maxAmountFootmenLvl2' => $maxAmountFootmenLvl2,
                                                                            'maxAmountFootmenLvl3' => $maxAmountFootmenLvl3,
                                                                            'maxAmountArchersLvl1' => $maxAmountArchersLvl1,
                                                                            'maxAmountArchersLvl2' => $maxAmountArchersLvl2,
                                                                            'maxAmountArchersLvl3' => $maxAmountArchersLvl3,
                                                                            'maxAmountCavalryLvl1' => $maxAmountCavalryLvl1,
                                                                            'maxAmountCavalryLvl2' => $maxAmountCavalryLvl2,
                                                                            'maxAmountCavalryLvl3' => $maxAmountCavalryLvl3));
    }

    /**
     * @Route("/battles/send_attack_confirm/{castleId}/{battleTempId}", name="user_battles_send_attack_confirm")
     * @param Request $request
     * @param int $castleId
     * @param int $battleTempId
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBattlesSendAttackConfirmAction(Request $request,int $castleId, int $battleTempId)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $form = $form = $this->createFormBuilder()
            ->add('Confirm', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        $battlesTemp = $this->em->getRepository(BattlesTemp::class)->find($battleTempId);

        if (null == $this->em->getRepository(Castle::class)->findOneBy(array('id' => $castleId)))
        {
            return $this->redirectToRoute('user_battles_send_attack_castle');
        }

        $castle = $this->em->getRepository(Castle::class)->findOneBy(array('id' => $castleId));

        if ($castle->getUserId() != $user)
        {
            return $this->redirectToRoute('user_battles_send_attack_castle');
        }

        if (null == $battlesTemp)
        {
            return $this->redirectToRoute('user_battles_send_attack_army', array('castleId' => $castleId));
        }
        if ($battlesTemp->getAttacker() != $user)
        {
            return $this->redirectToRoute('user_battles_send_attack_army', array('castleId' => $castleId));
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->battlesService->createNewBattle($castle, $battlesTemp);

            $success = true;
            return $this->redirectToRoute('user_battles', array('success' => $success));
        }

        return $this->render('view/user_battle_send_attack_confirm.html.twig', array('form' => $form->createView(),
                                                                                'battlesTemp' => $battlesTemp,
                                                                                'castleId' => $castleId));
    }

    /**
     * @Route("/battles/reports", name="user_battle_reports")
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function battleReportsAction()
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $allAttackReports = $this->em->getRepository(BattleReports::class)
            ->findBy(array('attacker' => $user->getUsername(), 'owner' => $user), array('battleDate' => 'DESC'));
        $allDefenceReports = $this->em->getRepository(BattleReports::class)
            ->findBy(array('defender' => $user->getUsername(), 'owner' => $user), array('battleDate' => 'DESC'));

        return $this->render('view/user_battle_reports.html.twig', array('allAttackReports' => $allAttackReports,
                                                                    'allDefenceReports' => $allDefenceReports));
    }

    /**
     * @Route("/battles/reports/{id}", name="user_battle_report_details")
     * @param int $id
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function battleReportDetailsAction(int $id)
    {
        $user = $this->getUser();
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);

        $username = $user->getUsername();

        if (null == $this->em->getRepository(BattleReports::class)->findOneBy(array('id' => $id)))
        {
            return $this->redirectToRoute('user_battle_reports');
        }

        $report = $this->em->getRepository(BattleReports::class)->findOneBy(array('id' => $id));

        if ($report->getOwner() != $user)
        {
            return $this->redirectToRoute('user_battle_reports');
        }

        $report->setVisited(true);
        $this->em->persist($report);
        $this->em->flush();

        return $this->render('view/user_battle_report_details.html.twig', array('report' => $report,
                                                                                     'user' => $username));
    }

    /**
     * @Route("/battles/reports/delete/{id}", name="user_battle_report_delete")
     * @param int $id
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function battleReportsDeleteAction(int $id)
    {
        $user = $this->getUser();

        if (null == $this->em->getRepository(BattleReports::class)->findOneBy(array('id' => $id)))
        {
            return $this->redirectToRoute('user_battle_reports');
        }

        $report = $this->em->getRepository(BattleReports::class)->findOneBy(array('id' => $id));

        if ($report->getOwner() != $user)
        {
            return $this->redirectToRoute('user_battle_reports');
        }

        $this->em->remove($report);
        $this->em->flush();

        return $this->redirectToRoute('user_battle_reports');
    }
}
