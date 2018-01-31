<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 29.1.2018 г.
 * Time: 09:39 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Castle;

interface ArmyTrainTimersServiceInterface
{
    public function createArmyTrainTimer(string $army, Castle $castle, int $amount, int $id);
}