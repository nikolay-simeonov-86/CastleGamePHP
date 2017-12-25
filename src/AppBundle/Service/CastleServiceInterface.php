<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 19.12.2017 г.
 * Time: 20:44 ч.
 */

namespace AppBundle\Service;


interface CastleServiceInterface
{
    public function getArmyCount();

    public function getBuildingLevels();

    public function purchaseArmy();

    public function purchaseBuilding();
}