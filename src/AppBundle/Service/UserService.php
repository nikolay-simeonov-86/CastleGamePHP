<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 19.12.2017 г.
 * Time: 20:15 ч.
 */

namespace AppBundle\Service;


class UserService implements UserServiceInterface
{

    public function getUserInformation()
    {
        return $array = 'pesho, castles, 1234';
    }

    public function calculateUserIncome()
    {
        return "mnogo pari";
    }

    public function getUserCastles()
    {
        // TODO: Implement getUserCastles() method.
    }

    public function getAllUserCastles()
    {
        // TODO: Implement getAllUserCastles() method.
    }

    public function getOneUserCastle()
    {
        // TODO: Implement getOneUserCastle() method.
    }

    public function setCoordinates()
    {
//        $coordinates = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
//        if (!null === $this->getDoctrine()->getRepository(UserRepository::class)->findBy(array('coordinates' => $coordinates)))
//        {
//
//        }
//        else
//        {
//
//        }
    }
}