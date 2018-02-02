<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 19.12.2017 г.
 * Time: 20:44 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\BuildingUpdateProperties;
use AppBundle\Entity\Castle;
use AppBundle\Entity\User;

interface CastleServiceInterface
{
    public function castleInformation(int $id);

    public function buildNewCastle(User $user, string $name);

    public function getArmyCount();

    public function getBuildingLevels();

    public function purchaseArmy();

    public function purchaseBuilding(string $building, User $user, Castle $castle, BuildingUpdateProperties $buildingUpdate);

    public function updateCastle(int $id);
}