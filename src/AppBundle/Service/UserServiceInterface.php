<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 19.12.2017 г.
 * Time: 19:54 ч.
 */

namespace AppBundle\Service;


interface UserServiceInterface
{
    public function getUserInformation();

    public function getAllUserCastles();

    public function getOneUserCastle();

    public function calculateUserIncome();

    public function setCoordinates();
}