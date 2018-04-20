<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 20.4.2018 г.
 * Time: 12:53 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;

interface NewCastleCostServiceInterface
{
    /**
     * @return mixed
     */
    public function createNewCastleCost();

    /**
     * @param User $user
     * @param string $name
     * @return mixed
     */
    public function buildNewCastle(User $user, string $name);

    /**
     * @param User $user
     * @return mixed
     */
    public function calculateCostForNewCastle(User $user);
}