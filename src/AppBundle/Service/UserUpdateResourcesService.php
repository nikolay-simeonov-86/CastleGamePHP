<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 8.2.2018 г.
 * Time: 14:00 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Castle;
use AppBundle\Entity\User;
use AppBundle\Entity\UserUpdateResources;
use AppBundle\Repository\UserUpdateResourcesRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserUpdateResourcesService implements UserUpdateResourcesServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserUpdateResourcesRepository
     */
    private $userUpdateResourcesRepository;

    /**
     * UserUpdateResourcesService constructor.
     * @param UserUpdateResourcesRepository $userUpdateResourcesRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(UserUpdateResourcesRepository $userUpdateResourcesRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->userUpdateResourcesRepository = $userUpdateResourcesRepository;
    }

    /**
     * @return null
     */
    public function updateUsersResources()
    {
        $currentDateTime = new \DateTime("now + 60 minutes");
        $users = $this->em->getRepository(User::class)->findAll();
        foreach ($users as $user)
        {
            $foodUser = 0;
            $metalUser = 0;
            $food = $user->getFood();
            $metal = $user->getMetal();
            $userUpdateResources = $this->em->getRepository(UserUpdateResources::class)->findOneBy(array('userId' => $user->getId()));
            $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $user->getId()));
            foreach ($castles as  $castle)
            {
                $foodTemp = 0;
                $metalTemp = 0;
                $tempInterval = date_diff($userUpdateResources->getLastUpdateDate(), $currentDateTime);
                $interval = $tempInterval->format("%y %m %d %h %i %s");
                list($year, $month, $day, $hour, $minute, $second) = array_map('intval', explode(' ', $interval));
                $minutes = (int)floor((($year * 365.25 + $month * 30 + $day) * 24 + $hour) * 60 + $minute + $second/60);
                if ($minutes > 1)
                {
                    if ($castle->getMineFoodLvl() == 0)
                    {
                        $foodTemp = 0;
                    }
                    elseif ($castle->getMineFoodLvl() == 1)
                    {
                        $foodTemp = $minutes*1;
                    }
                    elseif ($castle->getMineFoodLvl() == 2)
                    {
                        $foodTemp = $minutes*2;
                    }
                    elseif ($castle->getMineFoodLvl() == 3)
                    {
                        $foodTemp = $minutes*5;
                    }

                    if ($castle->getMineMetalLvl() == 0)
                    {
                        $metalTemp = 0;
                    }
                    elseif ($castle->getMineMetalLvl() == 1)
                    {
                        $metalTemp = $minutes*1;
                    }
                    elseif ($castle->getMineMetalLvl() == 2)
                    {
                        $metalTemp = $minutes*2;
                    }
                    elseif ($castle->getMineMetalLvl() == 3)
                    {
                        $metalTemp = $minutes*3;
                    }
                    $userUpdateResources->setLastUpdateDate(new \DateTime("now + 60 minutes"));
                    $this->em->persist($userUpdateResources);
                }
                $foodUser = $foodUser+$foodTemp;
                $metalUser = $metalUser+$metalTemp;
            }
            $user->setFood($food+$foodUser);
            $user->setMetal($metal+$metalUser);
            $this->em->persist($user);
            $this->em->flush();
        }
        return null;
    }
}