<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 6.2.2018 г.
 * Time: 17:00 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;

interface UserSpiesServiceInterface
{
    public function createUserSpy(User $loggedUser, int $id);

    public function purchaseUserSpy(User $loggedUser);

    public function expireUserSpy(User $loggedUser);
}