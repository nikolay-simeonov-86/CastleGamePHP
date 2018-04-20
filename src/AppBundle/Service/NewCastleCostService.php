<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 20.4.2018 г.
 * Time: 12:54 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Castle;
use AppBundle\Entity\NewCastleCost;
use AppBundle\Entity\User;
use AppBundle\Repository\NewCastleCostRepository;
use Doctrine\ORM\EntityManagerInterface;

class NewCastleCostService implements NewCastleCostServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var NewCastleCostRepository
     */
    private $newCastleCostRepository;

    /**
     * NewCastleCostService constructor.
     * @param NewCastleCostRepository $newCastleCostRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(NewCastleCostRepository $newCastleCostRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->newCastleCostRepository = $newCastleCostRepository;
    }

    /**
     * @param User $user
     * @param string $name
     * @return mixed|void
     */
    public function buildNewCastle(User $user, string $name)
    {
        $castle = new Castle();
        $castle->setName($name);
        $castle->setUserId($user);
        $castle->setCastleLvl(1);
        $castle->setMineFoodLvl(1);
        if ($name == 'Dwarf')
        {
            $castle->setCastlePicture('/pictures/Castles/DarkCastleDwarf.jpg');
        }
        elseif ($name == 'Ninja')
        {
            $castle->setCastlePicture('/pictures/Castles/DarkCastleNinja.jpg');
        }
        elseif ($name == 'Vampire')
        {
            $castle->setCastlePicture('/pictures/Castles/DarkCastleVampire.jpg');
        }
        elseif ($name == 'Elfs')
        {
            $castle->setCastlePicture('/pictures/Castles/LightCastleElfs.jpg');
        }
        elseif ($name == 'Mages')
        {
            $castle->setCastlePicture('/pictures/Castles/LightCastleMages.jpg');
        }
        elseif ($name == 'Olymp')
        {
            $castle->setCastlePicture('/pictures/Castles/LightCastleOlymp.jpg');
        }
        $this->em->persist($castle);
        $this->em->flush();
    }

    /**
     * @param User $user
     * @return mixed|null|string
     */
    public function calculateCostForNewCastle(User $user)
    {
        $foodBefore = $user->getFood();
        $metalBefore = $user->getMetal();

        $newCastleCostsArray = $this->newCastleCostRepository->findAll();

        /**
         * @var NewCastleCost $newCastleCosts
         */
        list($newCastleCosts) = $newCastleCostsArray;

        try
        {
            if ($foodBefore < $newCastleCosts->getFoodCost() && $metalBefore < $newCastleCosts->getMetalCost())
            {
                throw $exception = new \Exception('Not enough food and metal');
            }
            elseif ($foodBefore < $newCastleCosts->getFoodCost())
            {
                throw $exception = new \Exception('Not enough food');
            }
            elseif ($metalBefore < $newCastleCosts->getMetalCost())
            {
                throw $exception = new \Exception('Not enough metal');
            }
            else
            {
                $foodAfter = $foodBefore - $newCastleCosts->getFoodCost();
                $metalAfter = $metalBefore - $newCastleCosts->getMetalCost();
                $user->setFood($foodAfter);
                $user->setMetal($metalAfter);
            }
        }
        catch (\Exception $exception)
        {
            $message = $exception->getMessage();
            return $message;
        }

        return null;
    }

    /**
     * @return null
     */
    public function createNewCastleCost()
    {
        $newCastleCost = new NewCastleCost();
        $newCastleCost->setFoodCost(200000);
        $newCastleCost->setMetalCost(100000);

        $this->em->persist($newCastleCost);
        $this->em->flush();

        return null;
    }
}