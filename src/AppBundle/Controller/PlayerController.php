<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Army;
use AppBundle\Entity\ArmyStatistics;
use AppBundle\Entity\ArmyTrainTimers;
use AppBundle\Entity\BuildingUpdateProperties;
use AppBundle\Entity\BuildingUpdateTimers;
use AppBundle\Entity\Castle;
use AppBundle\Entity\User;
use AppBundle\Entity\UserSpies;
use AppBundle\Service\ArmyServiceInterface;
use AppBundle\Service\ArmyStatisticsServiceInterface;
use AppBundle\Service\ArmyTrainTimersServiceInterface;
use AppBundle\Service\CastleServiceInterface;
use AppBundle\Service\UserServiceInterface;
use AppBundle\Service\UserSpiesServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * CastleController constructor.
     * @param UserServiceInterface $userService
     * @param CastleServiceInterface $castleService
     * @param ArmyServiceInterface $armyService
     * @param EntityManagerInterface $em
     * @param ArmyTrainTimersServiceInterface $armyTrainTimersService
     * @param ArmyStatisticsServiceInterface $armyStatisticsService
     * @param UserSpiesServiceInterface $userSpiesService
     */
    public function __construct(UserServiceInterface $userService,
                                CastleServiceInterface $castleService,
                                ArmyServiceInterface $armyService,
                                EntityManagerInterface $em,
                                ArmyTrainTimersServiceInterface $armyTrainTimersService,
                                ArmyStatisticsServiceInterface $armyStatisticsService,
                                UserSpiesServiceInterface $userSpiesService)
    {
        $this->em = $em;
        $this->userService = $userService;
        $this->castleService = $castleService;
        $this->armyService = $armyService;
        $this->armyTrainTimersService = $armyTrainTimersService;
        $this->armyStatisticsService = $armyStatisticsService;
        $this->userSpiesService = $userSpiesService;
    }

    /**
     * @Route("/user", name="user")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userHomepageAction()
    {
        $user = $this->getUser();
        $userId = $user->getId();

        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));
        foreach ($castles as $castle)
        {
            $this->castleService->updateCastle($castle->getId());
        }

        return $this->render( 'view/user.html.twig', array('castles' => $castles, 'user' => $user));
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
        if ($this->getUser()->getId() === $id)
        {
            return $this->redirectToRoute('user');
        }

        $user = $this->em->getRepository(User::class)->find($id);
        $userId = $user->getId();

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
                $timeLeft = $tempInterval->format('%I minutes');
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
        $query = $this->em->createQuery('SELECT u.id, u.username, u.coordinates, u.castleIcon 
                                              FROM AppBundle\Entity\User u');
        $users = $query->getResult();

        return $this->render('view/map.html.twig', array('users' => $users));
    }

    /**
     * @Route("/castles", name="user_castles")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userCastlesAction(Request $request)
    {
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
        return $this->render('view/castles.html.twig', array('castles' => $castles, 'allUpdates' => $allUpdates, 'timeRemaining' => $timeRemaining));
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
        $form = $this->createFormBuilder()->add('upgrade', SubmitType::class)->getForm();
        $form->handleRequest($request);

        $user = $this->getUser();

        $castle = $this->em->getRepository(Castle::class)->find($id);
        $this->castleService->updateCastle($castle->getId());

        $buildingUpdate = $this->em->getRepository(BuildingUpdateProperties::class)->findOneBy(array('name' => $building));

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
                                                                 'message' => $message));
            }
            $message = $this->castleService->purchaseBuilding($building, $user, $castle, $buildingUpdate);

            if ($message)
            {
                return $this->render('view/upgrade.html.twig', array('form' => $form->createView(),
                                                                 'building' => $building,
                                                                 'message' => $message));
            }
            return $this->redirectToRoute('user_castles');
        }
        return $this->render('view/upgrade.html.twig', array('form' => $form->createView(), 'building' => $building));
    }

    /**
     * @Route("/army", name="user_army")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userArmyAction(Request $request)
    {
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
                    $allArmy[] = $army;
                }
            }
        }

        return $this->render('view/army.html.twig', array('castles' => $castles, 'allArmy' => $allArmy));
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
    public function userTrainArmy(int $id, string $army, Request $request)
    {
        $castle = $this->em->getRepository(Castle::class)->find($id);
        $currentDateTime = new \DateTime("now");

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
                                                                    'message' => $message));
            }
            return $this->redirectToRoute('confirm_train_army', array('army' => $army,
                                                                            'id' => $id,
                                                                            'amount' => $form->get('Amount')->getData()));
        }

        return $this->render('view/train_army.html.twig', array('form' => $form->createView(),
                                                            'army' => $army,
                                                            'maxAmount' => $maxAmount,
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
    public function userConfirmTrainArmy(int $id, string $army, int $amount, Request $request)
    {
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

        $armyTemp = $this->em->getRepository(Army::class)->findOneBy(array('name' => $army, 'level' => $level, 'castleId' => $castle));
        $this->armyService->updateArmy($armyTemp->getId());

        $armyVisualizeTemp = $this->em->getRepository(ArmyTrainTimers::class)->findBy(array('armyId' => $armyTemp, 'armyType' => $army));
        $counter = 0;
        foreach ($armyVisualizeTemp as $armyVisualizeOne)
        {
            $counter++;
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
            return $this->redirectToRoute('user_army');
        }
        return $this->render('view/confirm_train_army.html.twig', array('form' => $form->createView(),
                                                                    'amount' => $amount,
                                                                    'army' => $army,
                                                                    'prizeFood' => $prizeFood,
                                                                    'prizeMetal' => $prizeMetal,
                                                                    'trainTime' => $trainTime,
                                                                    'id' => $id));
    }
}