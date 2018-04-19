<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 19.4.2018 г.
 * Time: 11:47 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;

interface BattleReportsServiceInterface
{
    /**
     * @param User $user
     * @return mixed
     */
    public function getUserBattleReportsUnread(User $user);
}