<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Service\ArmyServiceInterface;
use AppBundle\Service\ArmyStatisticsServiceInterface;
use AppBundle\Service\ArmyTrainTimersServiceInterface;
use AppBundle\Service\BattleReportsServiceInterface;
use AppBundle\Service\BattlesServiceInterface;
use AppBundle\Service\BattlesTempService;
use AppBundle\Service\BattlesTempServiceInterface;
use AppBundle\Service\BuildingUpdatePropertiesService;
use AppBundle\Service\CastleServiceInterface;
use AppBundle\Service\NewCastleCostServiceInterface;
use AppBundle\Service\UserMessagesServiceInterface;
use AppBundle\Service\UserServiceInterface;
use AppBundle\Service\UserSpiesServiceInterface;
use AppBundle\Service\UserUpdateResourcesServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     * @var CastleServiceInterface
     */
    protected $castleService;

    /**
     * @var ArmyServiceInterface
     */
    protected $armyService;

    /**
     * @var ArmyTrainTimersServiceInterface
     */
    protected $armyTrainTimersService;

    /**
     * @var ArmyStatisticsServiceInterface
     */
    protected $armyStatisticsService;

    /**
     * @var UserSpiesServiceInterface
     */
    protected $userSpiesService;

    /**
     * @var UserUpdateResourcesServiceInterface
     */
    protected $userUpdateResourcesService;

    /**
     * @var UserMessagesServiceInterface
     */
    protected $userMessagesService;

    /**
     * @var BattlesServiceInterface
     */
    protected $battlesService;

    /**
     * @var BattlesTempServiceInterface
     */
    protected $battlesTempService;

    /**
     * @var BattleReportsServiceInterface
     */
    protected $battleReportsService;

    /**
     * @var NewCastleCostServiceInterface
     */
    protected $newCastleCostService;

    /**
     * @var BuildingUpdatePropertiesService
     */
    protected $buildingUpdatePropertiesService;

    /**
     * BaseController constructor.
     * @param EntityManagerInterface $em
     * @param UserServiceInterface $userService
     * @param CastleServiceInterface $castleService
     * @param ArmyServiceInterface $armyService
     * @param ArmyTrainTimersServiceInterface $armyTrainTimersService
     * @param ArmyStatisticsServiceInterface $armyStatisticsService
     * @param UserSpiesServiceInterface $userSpiesService
     * @param UserUpdateResourcesServiceInterface $userUpdateResourcesService
     * @param UserMessagesServiceInterface $userMessagesService
     * @param BattlesServiceInterface $battlesService
     * @param BattlesTempServiceInterface $battlesTempService
     * @param BattleReportsServiceInterface $battleReportsService
     * @param NewCastleCostServiceInterface $newCastleCostService
     * @param BuildingUpdatePropertiesService $buildingUpdatePropertiesService
     */
    public function __construct(EntityManagerInterface $em,
                                UserServiceInterface $userService,
                                CastleServiceInterface $castleService,
                                ArmyServiceInterface $armyService,
                                ArmyTrainTimersServiceInterface $armyTrainTimersService,
                                ArmyStatisticsServiceInterface $armyStatisticsService,
                                UserSpiesServiceInterface $userSpiesService,
                                UserUpdateResourcesServiceInterface $userUpdateResourcesService,
                                UserMessagesServiceInterface $userMessagesService,
                                BattlesServiceInterface $battlesService,
                                BattlesTempServiceInterface $battlesTempService,
                                BattleReportsServiceInterface $battleReportsService,
                                NewCastleCostServiceInterface $newCastleCostService,
                                BuildingUpdatePropertiesService $buildingUpdatePropertiesService)
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
        $this->buildingUpdatePropertiesService = $buildingUpdatePropertiesService;
    }


    /**
     * @param User $user
     */
    protected function updateUserMessageNotifications(User $user)
    {
        $unread_messages_count = $this->userMessagesService->getUserMessagesAllUnread($user);
        $unread_battle_reports_messages_count = $this->battleReportsService->getUserBattleReportsUnread($user);
        $this->get('twig')->addGlobal('user_battle_reports_messages_count', $unread_battle_reports_messages_count);
        $this->get('twig')->addGlobal('user_messages_count', $unread_messages_count);
    }
}