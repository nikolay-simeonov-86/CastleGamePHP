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
    /**
     * @param User $loggedUser
     * @param int $id
     * @return mixed
     */
    public function createUserSpy(User $loggedUser, int $id);

    /**
     * @param User $loggedUser
     * @return mixed
     */
    public function purchaseUserSpy(User $loggedUser);

    /**
     * @param User $loggedUser
     * @return mixed
     */
    public function expireUserSpy(User $loggedUser);
}