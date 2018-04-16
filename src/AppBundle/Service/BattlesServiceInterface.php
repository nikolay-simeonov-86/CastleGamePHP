<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 27.3.2018 г.
 * Time: 11:23 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\BattlesTemp;
use AppBundle\Entity\Castle;
use AppBundle\Entity\User;

interface BattlesServiceInterface
{
    /**
     * @param User $user
     * @return mixed
     */
    public function createAllUserArmyOutgoingAttacksArray(User $user);

    /**
     * @param User $user
     * @return mixed
     */
    public function createAllUserArmyIncomingAttacksArray(User $user);

    /**
     * @param Castle $castle
     * @param BattlesTemp $battlesTemp
     * @return mixed
     */
    public function createNewBattle(Castle $castle, BattlesTemp $battlesTemp);

    public function battleCalculationAndArmyReturn();
}