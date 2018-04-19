<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 19.4.2018 г.
 * Time: 11:49 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use AppBundle\Repository\BattleReportsRepository;
use Doctrine\ORM\EntityManagerInterface;

class BattleReportsService implements BattleReportsServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var BattleReportsRepository
     */
    private $battleReportsRepository;

    /**
     * BattleReportsService constructor.
     * @param BattleReportsRepository $battleReportsRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(BattleReportsRepository $battleReportsRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->battleReportsRepository = $battleReportsRepository;
    }

    /**
     * @param User $user
     * @return int
     */
    public function getUserBattleReportsUnread(User $user)
    {
        $allAttackReports = count($this->battleReportsRepository->findBy(array('attacker' => $user->getUsername(), 'visited' => false, 'owner' => $user)));
        $allDefenceReports = count($this->battleReportsRepository->findBy(array('defender' => $user->getUsername(), 'visited' => false, 'owner' => $user)));
        $count = $allAttackReports + $allDefenceReports;

        return $count;
    }
}