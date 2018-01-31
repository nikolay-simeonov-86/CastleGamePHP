<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 26.1.2018 г.
 * Time: 21:27 ч.
 */

namespace AppBundle\Service;

use AppBundle\Repository\ArmyStatisticsRepository;

interface ArmyStatisticsServiceInterface
{
    public function createArmyStatistics();

    public function armyCostAndTimeToTrain(string $army, int $level, int $amount);
}