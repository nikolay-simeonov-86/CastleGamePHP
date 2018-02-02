<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 26.1.2018 г.
 * Time: 21:29 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\ArmyStatistics;
use AppBundle\Repository\ArmyStatisticsRepository;
use Doctrine\ORM\EntityManagerInterface;

class ArmyStatisticsService implements ArmyStatisticsServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ArmyStatisticsRepository
     */
    private $armyStatisticsRepository;

    /**
     * UserService constructor.
     * @param ArmyStatisticsRepository $armyStatisticsRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(ArmyStatisticsRepository $armyStatisticsRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->armyStatisticsRepository = $armyStatisticsRepository;
    }

    /**
     * @return null
     */
    public function createArmyStatistics()
    {
        $footmenLvl1 = new ArmyStatistics();
        $footmenLvl1->setName('Footmen');
        $footmenLvl1->setLevel(1);
        $footmenLvl1->setHealth(10);
        $footmenLvl1->setDamage(1);
        $footmenLvl1->setCostFood(10);
        $footmenLvl1->setCostMetal(0);
        $footmenLvl1->setBonusDamage(5);
        $footmenLvl1->setTrainTime(1);

        $footmenLvl2 = new ArmyStatistics();
        $footmenLvl2->setName('Footmen');
        $footmenLvl2->setLevel(2);
        $footmenLvl2->setHealth(15);
        $footmenLvl2->setDamage(2);
        $footmenLvl2->setCostFood(10);
        $footmenLvl2->setCostMetal(10);
        $footmenLvl2->setBonusDamage(5);
        $footmenLvl2->setTrainTime(2);

        $footmenLvl3 = new ArmyStatistics();
        $footmenLvl3->setName('Footmen');
        $footmenLvl3->setLevel(3);
        $footmenLvl3->setHealth(30);
        $footmenLvl3->setDamage(3);
        $footmenLvl3->setCostFood(15);
        $footmenLvl3->setCostMetal(15);
        $footmenLvl3->setBonusDamage(5);
        $footmenLvl3->setTrainTime(3);

        $archersLvl1 = new ArmyStatistics();
        $archersLvl1->setName('Archers');
        $archersLvl1->setLevel(1);
        $archersLvl1->setHealth(15);
        $archersLvl1->setDamage(3);
        $archersLvl1->setCostFood(20);
        $archersLvl1->setCostMetal(0);
        $archersLvl1->setBonusDamage(5);
        $archersLvl1->setTrainTime(1);

        $archersLvl2 = new ArmyStatistics();
        $archersLvl2->setName('Archers');
        $archersLvl2->setLevel(2);
        $archersLvl2->setHealth(30);
        $archersLvl2->setDamage(5);
        $archersLvl2->setCostFood(20);
        $archersLvl2->setCostMetal(20);
        $archersLvl2->setBonusDamage(5);
        $archersLvl2->setTrainTime(3);

        $archersLvl3 = new ArmyStatistics();
        $archersLvl3->setName('Archers');
        $archersLvl3->setLevel(3);
        $archersLvl3->setHealth(50);
        $archersLvl3->setDamage(10);
        $archersLvl3->setCostFood(30);
        $archersLvl3->setCostMetal(30);
        $archersLvl3->setBonusDamage(5);
        $archersLvl3->setTrainTime(5);

        $cavalryLvl1 = new ArmyStatistics();
        $cavalryLvl1->setName('Cavalry');
        $cavalryLvl1->setLevel(1);
        $cavalryLvl1->setHealth(30);
        $cavalryLvl1->setDamage(10);
        $cavalryLvl1->setCostFood(50);
        $cavalryLvl1->setCostMetal(0);
        $cavalryLvl1->setBonusDamage(5);
        $cavalryLvl1->setTrainTime(2);

        $cavalryLvl2 = new ArmyStatistics();
        $cavalryLvl2->setName('Cavalry');
        $cavalryLvl2->setLevel(2);
        $cavalryLvl2->setHealth(50);
        $cavalryLvl2->setDamage(25);
        $cavalryLvl2->setCostFood(50);
        $cavalryLvl2->setCostMetal(50);
        $cavalryLvl2->setBonusDamage(5);
        $cavalryLvl2->setTrainTime(5);

        $cavalryLvl3 = new ArmyStatistics();
        $cavalryLvl3->setName('Cavalry');
        $cavalryLvl3->setLevel(3);
        $cavalryLvl3->setHealth(100);
        $cavalryLvl3->setDamage(50);
        $cavalryLvl3->setCostFood(100);
        $cavalryLvl3->setCostMetal(100);
        $cavalryLvl3->setBonusDamage(5);
        $cavalryLvl3->setTrainTime(10);

        $this->em->persist($footmenLvl1);
        $this->em->persist($footmenLvl2);
        $this->em->persist($footmenLvl3);
        $this->em->persist($archersLvl1);
        $this->em->persist($archersLvl2);
        $this->em->persist($archersLvl3);
        $this->em->persist($cavalryLvl1);
        $this->em->persist($cavalryLvl2);
        $this->em->persist($cavalryLvl3);
        $this->em->flush();

        return null;
    }

    /**
     * @param string $army
     * @param int $level
     * @param int $amount
     * @return array
     */
    public function armyCostAndTimeToTrain(string $army, int $level, int $amount)
    {
        $armyStats = $this->armyStatisticsRepository->findOneBy(array('name' => $army, 'level' => $level));
        $prizeFood = $amount*$armyStats->getCostFood();
        $prizeMetal = $amount*$armyStats->getCostMetal();
        $trainTimeMinutes = $amount*$armyStats->getTrainTime();
        $trainTime = date('H:i', mktime(0,$trainTimeMinutes));

        return array($prizeFood, $prizeMetal, $trainTime);
    }
}