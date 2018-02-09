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
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @param UserInterface $user
     * @return null|object
     */
    public function getUserInformation(UserInterface $user)
    {
        return $users = $this->userRepository->find($user->getUsername());
    }

    public function calculateUserIncome()
    {
        return "mnogo pari";
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