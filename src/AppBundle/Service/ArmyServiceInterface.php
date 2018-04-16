<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 29.1.2018 г.
 * Time: 14:32 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Castle;
use AppBundle\Entity\User;

interface ArmyServiceInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function updateArmy(int $id);

    /**
     * @param User $user
     * @param int $prizeFood
     * @param int $prizeMetal
     * @return mixed
     */
    public function trainArmyUserPayment(User $user, int $prizeFood, int $prizeMetal);

    /**
     * @param int $userFood
     * @param int $userMetal
     * @param string $army
     * @param int $level
     * @return mixed
     */
    public function maximumArmyAmountToTrain(int $userFood, int $userMetal, string $army, int $level);

    /**
     * @param int $castleId
     * @return mixed
     */
    public function maximumArmyAmountForBattle(int $castleId);
}