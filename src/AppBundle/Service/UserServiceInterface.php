<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 19.12.2017 г.
 * Time: 19:54 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserServiceInterface
{
    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function getUserInformation(UserInterface $user);

    /**
     * @return mixed
     */
    public function setCoordinates();
}