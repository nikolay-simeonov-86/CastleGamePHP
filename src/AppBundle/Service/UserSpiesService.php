<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 6.2.2018 г.
 * Time: 17:01 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use AppBundle\Entity\UserSpies;
use AppBundle\Repository\UserSpiesRepository;
use ClassesWithParents\D;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UserSpiesService implements UserSpiesServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserSpiesRepository
     */
    private $userSpiesRepository;

    /**
     * UserSpiesService constructor.
     * @param UserSpiesRepository $userSpiesRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(UserSpiesRepository $userSpiesRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->userSpiesRepository = $userSpiesRepository;
    }

    /**
     * @param User $loggedUser
     * @param int $id
     */
    public function createUserSpy(User $loggedUser, int $id)
    {
        $userSpy = new UserSpies();
        $userSpy->setUserId($loggedUser);
        $userSpy->setTargetUserId($id);
        $startDate = new DateTime("now + 60 minutes");
        $expirationDate = new DateTime("now + 120 minutes");
        $userSpy->setStartDate($startDate);
        $userSpy->setExpirationDate($expirationDate);
        $this->em->persist($userSpy);
        $this->em->flush();
    }

    /**
     * @param User $loggedUser
     * @return null|string
     */
    public function purchaseUserSpy(User $loggedUser)
    {
        try
        {
            $food = $loggedUser->getFood();
            $metal = $loggedUser->getMetal();
            $foodafter = $food - 100;
            $metalafter = $metal - 100;
            if ($foodafter < 0 && $metalafter < 0)
            {
                $foodMessage = abs($foodafter);
                $metalMessage = abs($metalafter);
                throw $exception = new Exception("Not enough resources to purchase a spy. You need $foodMessage more food and $metalMessage more metal.");
            }
            if ($foodafter < 0)
            {
                $foodMessage = abs($foodafter);
                throw $exception = new Exception("Not enough food to purchase a spy. You need $foodMessage more food.");
            }
            if ($metalafter < 0)
            {
                $metalMessage = abs($metalafter);
                throw $exception = new Exception("Not enough metal to purchase a spy. You need $metalMessage more metal.");
            }
            $loggedUser->setFood($foodafter);
            $loggedUser->setMetal($metalafter);
            $this->em->persist($loggedUser);
            $this->em->flush();
        }
        catch (Exception $exception)
        {
            return $message = $exception->getMessage();
        }
        return null;
    }

    /**
     * @param User $loggedUser
     */
    public function expireUserSpy(User $loggedUser)
    {
        $userSpies = $this->em->getRepository(UserSpies::class)->findBy(array('userId' => $loggedUser));
        $currentDateTime = new \DateTime("now");
        if ($userSpies)
        {
            foreach ($userSpies as $userSpy)
            {
                if ($userSpy->getExpirationDate() < $currentDateTime)
                {
                    $this->em->remove($userSpy);
                    $this->em->flush();
                }
            }
        }
    }
}