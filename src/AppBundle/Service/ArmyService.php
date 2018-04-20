<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 29.1.2018 г.
 * Time: 14:45 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Army;
use AppBundle\Entity\ArmyStatistics;
use AppBundle\Entity\ArmyTrainTimers;
use AppBundle\Entity\User;
use AppBundle\Repository\ArmyRepository;
use Doctrine\ORM\EntityManagerInterface;

class ArmyService implements ArmyServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ArmyRepository
     */
    private $armyRepository;

    /**
     * ArmyService constructor.
     * @param ArmyRepository $armyRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(ArmyRepository $armyRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->armyRepository = $armyRepository;
    }

    /**
     * @param int $id
     */
    public function updateArmy(int $id)
    {
        $army = $this->armyRepository->find($id);
        $updates = $this->em->getRepository(ArmyTrainTimers::class)->findBy(array('armyId' => $army->getId()));
        if ($updates)
        {
            foreach ($updates as $update)
            {
                $currentDatetime = new \DateTime("now");
                if (null != $update->getFinishTime())
                {
                    if ($update->getFinishTime() < $currentDatetime)
                    {
                        $army->setAmount($army->getAmount() + $update->getTrainAmount());
                        $this->em->persist($army);
                        $this->em->remove($update);
                        $this->em->flush();
                    }
                }
            }
        }
    }

    /**
     * @param User $user
     * @param int $prizeFood
     * @param int $prizeMetal
     * @return null|string
     */
    public function trainArmyUserPayment(User $user, int $prizeFood, int $prizeMetal)
    {
        $userFood = $user->getFood();
        $userMetal = $user->getMetal();
        try
        {
            if ($userFood < $prizeFood && $userMetal < $prizeMetal)
            {
                throw $exception = new \Exception('Not enough food and metal');
            }
            elseif ($userFood < $prizeFood)
            {
                throw $exception = new \Exception('Not enough food');
            }
            elseif ($userMetal < $prizeMetal)
            {
                throw $exception = new \Exception('Not enough metal');
            }
            else
            {
                $userFoodAfter = $userFood - $prizeFood;
                $userMetalAfter = $userMetal - $prizeMetal;
                $user->setFood($userFoodAfter);
                $user->setMetal($userMetalAfter);
            }
        }
        catch (\Exception $exception)
        {
            $message = $exception->getMessage();
            return $message;
        }
        $this->em->persist($user);
        $this->em->flush();
        return null;
    }

    /**
     * @param int $userFood
     * @param int $userMetal
     * @param string $army
     * @param int $level
     * @return int
     */
    public function maximumArmyAmountToTrain(int $userFood, int $userMetal, string $army, int $level)
    {
        $armyStatistics = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => $army, 'level' => $level));
        $foodCost = $armyStatistics->getCostFood();
        $metalCost = $armyStatistics->getCostMetal();
        $maxWithFood = $userFood/$foodCost;
        if ($metalCost == 0)
        {
            return $maxAmount = (int)floor($maxWithFood);
        }
        else
        {
            $maxWithMetal = $userMetal/$metalCost;
            return $maxAmount = (int)floor(min($maxWithFood, $maxWithMetal));
        }
    }

    /**
     * @param int $castleId
     * @return array|mixed
     */
    public function maximumArmyAmountForBattle(int $castleId)
    {
        if ($this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Footmen', 'level' => 1)))
        {
            $temp = $this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Footmen', 'level' => 1));
            $maxAmountFootmenLvl1 = $temp->getAmount();
        }
        else
        {
            $maxAmountFootmenLvl1 = 0;
        }
        if ($this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Footmen', 'level' => 2)))
        {
            $temp = $this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Footmen', 'level' => 2));
            $maxAmountFootmenLvl2 = $temp->getAmount();
        }
        else
        {
            $maxAmountFootmenLvl2 = 0;
        }
        if ($this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Footmen', 'level' => 3)))
        {
            $temp = $this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Footmen', 'level' => 3));
            $maxAmountFootmenLvl3 = $temp->getAmount();
        }
        else
        {
            $maxAmountFootmenLvl3 = 0;
        }
        if ($this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Archers', 'level' => 1)))
        {
            $temp = $this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Archers', 'level' => 1));
            $maxAmountArchersLvl1 = $temp->getAmount();
        }
        else
        {
            $maxAmountArchersLvl1 = 0;
        }
        if ($this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Archers', 'level' => 2)))
        {
            $temp = $this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Archers', 'level' => 2));
            $maxAmountArchersLvl2 = $temp->getAmount();
        }
        else
        {
            $maxAmountArchersLvl2 = 0;
        }
        if ($this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Archers', 'level' => 3)))
        {
            $temp = $this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Archers', 'level' => 3));
            $maxAmountArchersLvl3 = $temp->getAmount();
        }
        else
        {
            $maxAmountArchersLvl3 = 0;
        }
        if ($this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Cavalry', 'level' => 1)))
        {
            $temp = $this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Cavalry', 'level' => 1));
            $maxAmountCavalryLvl1 = $temp->getAmount();
        }
        else
        {
            $maxAmountCavalryLvl1 = 0;
        }
        if ($this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Cavalry', 'level' => 2)))
        {
            $temp = $this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Cavalry', 'level' => 2));
            $maxAmountCavalryLvl2 = $temp->getAmount();
        }
        else
        {
            $maxAmountCavalryLvl2 = 0;
        }
        if ($this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Cavalry', 'level' => 3)))
        {
            $temp = $this->em->getRepository(Army::class)->findOneBy(array('castleId' => $castleId, 'name' => 'Cavalry', 'level' => 3));
            $maxAmountCavalryLvl3 = $temp->getAmount();
        }
        else
        {
            $maxAmountCavalryLvl3 = 0;
        }
        return array($maxAmountFootmenLvl1,
                    $maxAmountFootmenLvl2,
                    $maxAmountFootmenLvl3,
                    $maxAmountArchersLvl1,
                    $maxAmountArchersLvl2,
                    $maxAmountArchersLvl3,
                    $maxAmountCavalryLvl1,
                    $maxAmountCavalryLvl2,
                    $maxAmountCavalryLvl3);
    }
}