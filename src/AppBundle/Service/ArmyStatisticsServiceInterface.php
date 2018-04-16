<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 26.1.2018 г.
 * Time: 21:27 ч.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Castle;
use AppBundle\Repository\ArmyStatisticsRepository;

interface ArmyStatisticsServiceInterface
{
    /**
     * @return mixed
     */
    public function createArmyStatistics();

    /**
     * @param string $army
     * @param int $level
     * @param int $amount
     * @return mixed
     */
    public function armyCostAndTimeToTrain(string $army, int $level, int $amount);

    /**
     * @param Castle $castle
     * @param string $army
     * @return mixed
     */
    public function armyCostForOneUnit(Castle $castle, string $army);
}