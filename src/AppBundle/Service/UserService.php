<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 19.12.2017 г.
 * Time: 20:15 ч.
 */

namespace AppBundle\Service;


use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class UserService implements UserServiceInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
    }

    /**
     * @return null|object
     */
    public function getUserInformation()
    {
        return $userInfo = $this->userRepository->findOneBy(array('id' => $_SESSION['id']));
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

    public function getOneUserCastles()
    {
        // TODO: Implement getOneUserCastle() method.
    }

    /**
     * @return string
     */
    public function setCoordinates()
    {
        do {
            $coordinates = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
        }
        while (null !== $this->userRepository->findOneBy(array('coordinates' => $coordinates)));

        return $coordinates;
    }
}