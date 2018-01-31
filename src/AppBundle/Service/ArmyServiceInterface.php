<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 29.1.2018 г.
 * Time: 14:32 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;

interface ArmyServiceInterface
{
    public function updateArmy(int $id);

    public function trainArmyUserPayment(User $user, int $prizeFood, int $prizeMetal);
}