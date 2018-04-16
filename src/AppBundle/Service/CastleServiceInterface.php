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
    /**
     * @param int $id
     * @return mixed
     */
    public function castleInformation(int $id);

    /**
     * @param User $user
     * @param string $name
     * @return mixed
     */
    public function buildNewCastle(User $user, string $name);

    /**
     * @param string $building
     * @param Castle $castle
     * @param BuildingUpdateProperties $buildingUpdate
     * @return mixed
     */
    public function purchaseBuildingCost(string $building, Castle $castle, BuildingUpdateProperties $buildingUpdate);

    /**
     * @param string $building
     * @param User $user
     * @param Castle $castle
     * @param BuildingUpdateProperties $buildingUpdate
     * @return mixed
     */
    public function purchaseBuilding(string $building, User $user, Castle $castle, BuildingUpdateProperties $buildingUpdate);

    /**
     * @param int $id
     * @return mixed
     */
    public function updateCastle(int $id);
}