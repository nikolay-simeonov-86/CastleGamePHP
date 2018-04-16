<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 27.3.2018 г.
 * Time: 11:24 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Army;
use AppBundle\Entity\ArmyBattles;
use AppBundle\Entity\ArmyStatistics;
use AppBundle\Entity\BattleReports;
use AppBundle\Entity\Battles;
use AppBundle\Entity\BattlesTemp;
use AppBundle\Entity\Castle;
use AppBundle\Entity\User;
use AppBundle\Repository\BattlesRepository;
use Doctrine\ORM\EntityManagerInterface;

class BattlesService implements BattlesServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var BattlesRepository
     */
    private $battlesRepository;

    /**
     * BattlesService constructor.
     * @param BattlesRepository $battlesRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(BattlesRepository $battlesRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->battlesRepository = $battlesRepository;
    }

    /**
     * @param User $user
     * @return array
     */
    public function createAllUserArmyOutgoingAttacksArray(User $user)
    {
        $currentDatetime = new \DateTime("now");

        if ($this->em->getRepository(Battles::class)->findBy(array('attacker' => $user)))
        {
            $attacks = $this->em->getRepository(Battles::class)->findBy(array('attacker' => $user));
            $attacksArray = [];
            foreach ($attacks as $attack)
            {
                $tempInterval = date_diff($attack->getReachDate(), $currentDatetime);
                $interval = $tempInterval->format('%H hours and %I minutes');
                $temp['attacker'] = $attack->getAttacker()->getUsername();
                $temp['defender'] = $attack->getDefender();
                if ($attack->getFootmenLvl1())
                {
                    $temp['footmenLvl1'] = $attack->getFootmenLvl1()->getAmount();
                }
                else
                {
                    $temp['footmenLvl1'] = 0;
                }
                if ($attack->getFootmenLvl2())
                {
                    $temp['footmenLvl2'] = $attack->getFootmenLvl2()->getAmount();
                }
                else
                {
                    $temp['footmenLvl2'] = 0;
                }
                if ($attack->getFootmenLvl3())
                {
                    $temp['footmenLvl3'] = $attack->getFootmenLvl3()->getAmount();
                }
                else
                {
                    $temp['footmenLvl3'] = 0;
                }
                if ($attack->getArchersLvl1())
                {
                    $temp['archersLvl1'] = $attack->getArchersLvl1()->getAmount();
                }
                else
                {
                    $temp['archersLvl1'] = 0;
                }
                if ($attack->getArchersLvl2())
                {
                    $temp['archersLvl2'] = $attack->getArchersLvl2()->getAmount();
                }
                else
                {
                    $temp['archersLvl2'] = 0;
                }
                if ($attack->getArchersLvl3())
                {
                    $temp['archersLvl3'] = $attack->getArchersLvl3()->getAmount();
                }
                else
                {
                    $temp['archersLvl3'] = 0;
                }
                if ($attack->getCavalryLvl1())
                {
                    $temp['cavalryLvl1'] = $attack->getCavalryLvl1()->getAmount();
                }
                else
                {
                    $temp['cavalryLvl1'] = 0;
                }
                if ($attack->getCavalryLvl2())
                {
                    $temp['cavalryLvl2'] = $attack->getCavalryLvl2()->getAmount();
                }
                else
                {
                    $temp['cavalryLvl2'] = 0;
                }
                if ($attack->getCavalryLvl3())
                {
                    $temp['cavalryLvl3'] = $attack->getCavalryLvl3()->getAmount();
                }
                else
                {
                    $temp['cavalryLvl3'] = 0;
                }
                $temp['timeLeft'] = $interval;
                $attacksArray[] = $temp;
            }
        }
        else
        {
            $attacksArray = [];
        }
        return $attacksArray;
    }

    /**
     * @param User $user
     * @return array
     */
    public function createAllUserArmyIncomingAttacksArray(User $user)
    {
        $currentDatetime = new \DateTime("now");

        if ($this->em->getRepository(Battles::class)->findBy(array('defender' => $user->getUsername())))
        {
            $attacks = $this->em->getRepository(Battles::class)->findBy(array('defender' => $user->getUsername()));
            $attacksArray = [];
            foreach ($attacks as $attack)
            {
                $tempInterval = date_diff($attack->getReachDate(), $currentDatetime);
                $interval = $tempInterval->format('%H hours and %I minutes');
                $temp['attacker'] = $attack->getAttacker()->getUsername();
                $temp['defender'] = $attack->getDefender();
                if ($attack->getFootmenLvl1())
                {
                    $temp['footmenLvl1'] = $attack->getFootmenLvl1()->getAmount();
                }
                else
                {
                    $temp['footmenLvl1'] = 0;
                }
                if ($attack->getFootmenLvl2())
                {
                    $temp['footmenLvl2'] = $attack->getFootmenLvl2()->getAmount();
                }
                else
                {
                    $temp['footmenLvl2'] = 0;
                }
                if ($attack->getFootmenLvl3())
                {
                    $temp['footmenLvl3'] = $attack->getFootmenLvl3()->getAmount();
                }
                else
                {
                    $temp['footmenLvl3'] = 0;
                }
                if ($attack->getArchersLvl1())
                {
                    $temp['archersLvl1'] = $attack->getArchersLvl1()->getAmount();
                }
                else
                {
                    $temp['archersLvl1'] = 0;
                }
                if ($attack->getArchersLvl2())
                {
                    $temp['archersLvl2'] = $attack->getArchersLvl2()->getAmount();
                }
                else
                {
                    $temp['archersLvl2'] = 0;
                }
                if ($attack->getArchersLvl3())
                {
                    $temp['archersLvl3'] = $attack->getArchersLvl3()->getAmount();
                }
                else
                {
                    $temp['archersLvl3'] = 0;
                }
                if ($attack->getCavalryLvl1())
                {
                    $temp['cavalryLvl1'] = $attack->getCavalryLvl1()->getAmount();
                }
                else
                {
                    $temp['cavalryLvl1'] = 0;
                }
                if ($attack->getCavalryLvl2())
                {
                    $temp['cavalryLvl2'] = $attack->getCavalryLvl2()->getAmount();
                }
                else
                {
                    $temp['cavalryLvl2'] = 0;
                }
                if ($attack->getCavalryLvl3())
                {
                    $temp['cavalryLvl3'] = $attack->getCavalryLvl3()->getAmount();
                }
                else
                {
                    $temp['cavalryLvl3'] = 0;
                }
                $temp['timeLeft'] = $interval;
                $attacksArray[] = $temp;
            }
        }
        else
        {
            $attacksArray = [];
        }
        return $attacksArray;
    }

    /**
     * @param Castle $castle
     * @param BattlesTemp $battlesTemp
     * @return mixed|void
     */
    public function createNewBattle(Castle $castle, BattlesTemp $battlesTemp)
    {
        $army = $this->em->getRepository(Army::class)->findBy(array('castleId' => $castle));
        $reachInterval = $battlesTemp->getReachTime()*60;
        $reachDate = new \DateTime("now + $reachInterval minutes");
        $returnInterval = $reachInterval*2;
        $returnDate = new \DateTime("now + {$returnInterval} minutes");

        $battle = new Battles();
        $battle->setDefender($battlesTemp->getDefender());
        $battle->setAttacker($battlesTemp->getAttacker());
        $battle->setReachDate($reachDate);
        $battle->setReturnDate($returnDate);
        $battle->setCastleId($castle->getId());

        // Footmen
        if ($battlesTemp->getFootmenLvl1() > 0)
        {
            foreach ($army as $singleArmy)
            {
                if ($singleArmy->getName() === "Footmen" && $singleArmy->getLevel() === 1)
                {
                    $amountAfter = $singleArmy->getAmount() - $battlesTemp->getFootmenLvl1();
                    if ($amountAfter === 0)
                    {
                        $this->em->remove($singleArmy);
                    }
                    else
                    {
                        $singleArmy->setAmount($amountAfter);
                    }

                    $footmenLvl1Stats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Footmen', 'level' => 1));
                    $footmenLvl1 = new ArmyBattles();
                    $footmenLvl1->setAmount($battlesTemp->getFootmenLvl1());
                    $footmenLvl1->setUserId($battlesTemp->getAttacker());
                    $footmenLvl1->setBonusVersus($footmenLvl1Stats->getBonusVersus());
                    $footmenLvl1->setLevel($footmenLvl1Stats->getLevel());
                    $footmenLvl1->setName($footmenLvl1Stats->getName());
                    $footmenLvl1->setArmyPicture($singleArmy->getArmyPicture());
                    $footmenLvl1->setHealth($footmenLvl1Stats->getHealth());
                    $footmenLvl1->setDamage($footmenLvl1Stats->getDamage());
                    $footmenLvl1->setBonusDamage($footmenLvl1Stats->getBonusDamage());

                    $this->em->persist($footmenLvl1);
                    $this->em->flush();

                    $battle->setFootmenLvl1($footmenLvl1);
                }
            }
        }
        if ($battlesTemp->getFootmenLvl2() > 0)
        {
            foreach ($army as $singleArmy)
            {
                if ($singleArmy->getName() === "Footmen" && $singleArmy->getLevel() === 2)
                {
                    $amountAfter = $singleArmy->getAmount() - $battlesTemp->getFootmenLvl2();
                    $singleArmy->setAmount($amountAfter);
                    if ($amountAfter === 0)
                    {
                        $this->em->remove($singleArmy);
                    }
                    else
                    {
                        $singleArmy->setAmount($amountAfter);
                    }

                    $footmenLvl2Stats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Footmen', 'level' => 2));
                    $footmenLvl2 = new ArmyBattles();
                    $footmenLvl2->setAmount($battlesTemp->getFootmenLvl2());
                    $footmenLvl2->setUserId($battlesTemp->getAttacker());
                    $footmenLvl2->setBonusVersus($footmenLvl2Stats->getBonusVersus());
                    $footmenLvl2->setLevel($footmenLvl2Stats->getLevel());
                    $footmenLvl2->setName($footmenLvl2Stats->getName());
                    $footmenLvl2->setArmyPicture($singleArmy->getArmyPicture());
                    $footmenLvl2->setHealth($footmenLvl2Stats->getHealth());
                    $footmenLvl2->setDamage($footmenLvl2Stats->getDamage());
                    $footmenLvl2->setBonusDamage($footmenLvl2Stats->getBonusDamage());

                    $this->em->persist($footmenLvl2);
                    $this->em->flush();

                    $battle->setFootmenLvl2($footmenLvl2);
                }
            }
        }
        if ($battlesTemp->getFootmenLvl3() > 0)
        {
            foreach ($army as $singleArmy)
            {
                if ($singleArmy->getName() === "Footmen" && $singleArmy->getLevel() === 3)
                {
                    $amountAfter = $singleArmy->getAmount() - $battlesTemp->getFootmenLvl3();
                    $singleArmy->setAmount($amountAfter);
                    if ($amountAfter === 0)
                    {
                        $this->em->remove($singleArmy);
                    }
                    else
                    {
                        $singleArmy->setAmount($amountAfter);
                    }

                    $footmenLvl3Stats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Footmen', 'level' => 3));
                    $footmenLvl3 = new ArmyBattles();
                    $footmenLvl3->setAmount($battlesTemp->getFootmenLvl3());
                    $footmenLvl3->setUserId($battlesTemp->getAttacker());
                    $footmenLvl3->setBonusVersus($footmenLvl3Stats->getBonusVersus());
                    $footmenLvl3->setLevel($footmenLvl3Stats->getLevel());
                    $footmenLvl3->setName($footmenLvl3Stats->getName());
                    $footmenLvl3->setArmyPicture($singleArmy->getArmyPicture());
                    $footmenLvl3->setHealth($footmenLvl3Stats->getHealth());
                    $footmenLvl3->setDamage($footmenLvl3Stats->getDamage());
                    $footmenLvl3->setBonusDamage($footmenLvl3Stats->getBonusDamage());

                    $this->em->persist($footmenLvl3);
                    $this->em->flush();

                    $battle->setFootmenLvl3($footmenLvl3);
                }
            }
        }

        // Archers
        if ($battlesTemp->getArchersLvl1() > 0)
        {
            foreach ($army as $singleArmy)
            {
                if ($singleArmy->getName() === "Archers" && $singleArmy->getLevel() === 1)
                {
                    $amountAfter = $singleArmy->getAmount() - $battlesTemp->getArchersLvl1();
                    $singleArmy->setAmount($amountAfter);
                    if ($amountAfter === 0)
                    {
                        $this->em->remove($singleArmy);
                    }
                    else
                    {
                        $singleArmy->setAmount($amountAfter);
                    }

                    $archersLvl1Stats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Archers', 'level' => 1));
                    $archersLvl1 = new ArmyBattles();
                    $archersLvl1->setAmount($battlesTemp->getArchersLvl1());
                    $archersLvl1->setUserId($battlesTemp->getAttacker());
                    $archersLvl1->setBonusVersus($archersLvl1Stats->getBonusVersus());
                    $archersLvl1->setLevel($archersLvl1Stats->getLevel());
                    $archersLvl1->setName($archersLvl1Stats->getName());
                    $archersLvl1->setArmyPicture($singleArmy->getArmyPicture());
                    $archersLvl1->setHealth($archersLvl1Stats->getHealth());
                    $archersLvl1->setDamage($archersLvl1Stats->getDamage());
                    $archersLvl1->setBonusDamage($archersLvl1Stats->getBonusDamage());

                    $this->em->persist($archersLvl1);
                    $this->em->flush();

                    $battle->setArchersLvl1($archersLvl1);
                }
            }
        }
        if ($battlesTemp->getArchersLvl2() > 0)
        {
            foreach ($army as $singleArmy)
            {
                if ($singleArmy->getName() === "Archers" && $singleArmy->getLevel() === 2)
                {
                    $amountAfter = $singleArmy->getAmount() - $battlesTemp->getArchersLvl2();
                    $singleArmy->setAmount($amountAfter);
                    if ($amountAfter === 0)
                    {
                        $this->em->remove($singleArmy);
                    }
                    else
                    {
                        $singleArmy->setAmount($amountAfter);
                    }

                    $archersLvl2Stats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Archers', 'level' => 2));
                    $archersLvl2 = new ArmyBattles();
                    $archersLvl2->setAmount($battlesTemp->getArchersLvl2());
                    $archersLvl2->setUserId($battlesTemp->getAttacker());
                    $archersLvl2->setBonusVersus($archersLvl2Stats->getBonusVersus());
                    $archersLvl2->setLevel($archersLvl2Stats->getLevel());
                    $archersLvl2->setName($archersLvl2Stats->getName());
                    $archersLvl2->setArmyPicture($singleArmy->getArmyPicture());
                    $archersLvl2->setHealth($archersLvl2Stats->getHealth());
                    $archersLvl2->setDamage($archersLvl2Stats->getDamage());
                    $archersLvl2->setBonusDamage($archersLvl2Stats->getBonusDamage());

                    $this->em->persist($archersLvl2);
                    $this->em->flush();

                    $battle->setArchersLvl2($archersLvl2);
                }
            }
        }
        if ($battlesTemp->getArchersLvl3() > 0)
        {
            foreach ($army as $singleArmy)
            {
                if ($singleArmy->getName() === "Archers" && $singleArmy->getLevel() === 3)
                {
                    $amountAfter = $singleArmy->getAmount() - $battlesTemp->getArchersLvl3();
                    $singleArmy->setAmount($amountAfter);
                    if ($amountAfter === 0)
                    {
                        $this->em->remove($singleArmy);
                    }
                    else
                    {
                        $singleArmy->setAmount($amountAfter);
                    }

                    $archersLvl3Stats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Archers', 'level' => 3));
                    $archersLvl3 = new ArmyBattles();
                    $archersLvl3->setAmount($battlesTemp->getArchersLvl3());
                    $archersLvl3->setUserId($battlesTemp->getAttacker());
                    $archersLvl3->setBonusVersus($archersLvl3Stats->getBonusVersus());
                    $archersLvl3->setLevel($archersLvl3Stats->getLevel());
                    $archersLvl3->setName($archersLvl3Stats->getName());
                    $archersLvl3->setArmyPicture($singleArmy->getArmyPicture());
                    $archersLvl3->setHealth($archersLvl3Stats->getHealth());
                    $archersLvl3->setDamage($archersLvl3Stats->getDamage());
                    $archersLvl3->setBonusDamage($archersLvl3Stats->getBonusDamage());

                    $this->em->persist($archersLvl3);
                    $this->em->flush();

                    $battle->setArchersLvl3($archersLvl3);
                }
            }
        }

        // Cavalry
        if ($battlesTemp->getCavalryLvl1() > 0)
        {
            foreach ($army as $singleArmy)
            {
                if ($singleArmy->getName() === "Cavalry" && $singleArmy->getLevel() === 1)
                {
                    $amountAfter = $singleArmy->getAmount() - $battlesTemp->getCavalryLvl1();
                    $singleArmy->setAmount($amountAfter);
                    if ($amountAfter === 0)
                    {
                        $this->em->remove($singleArmy);
                    }
                    else
                    {
                        $singleArmy->setAmount($amountAfter);
                    }

                    $cavalryLvl1Stats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Cavalry', 'level' => 1));
                    $cavalryLvl1 = new ArmyBattles();
                    $cavalryLvl1->setAmount($battlesTemp->getCavalryLvl1());
                    $cavalryLvl1->setUserId($battlesTemp->getAttacker());
                    $cavalryLvl1->setBonusVersus($cavalryLvl1Stats->getBonusVersus());
                    $cavalryLvl1->setLevel($cavalryLvl1Stats->getLevel());
                    $cavalryLvl1->setName($cavalryLvl1Stats->getName());
                    $cavalryLvl1->setArmyPicture($singleArmy->getArmyPicture());
                    $cavalryLvl1->setHealth($cavalryLvl1Stats->getHealth());
                    $cavalryLvl1->setDamage($cavalryLvl1Stats->getDamage());
                    $cavalryLvl1->setBonusDamage($cavalryLvl1Stats->getBonusDamage());

                    $this->em->persist($cavalryLvl1);
                    $this->em->flush();

                    $battle->setCavalryLvl1($cavalryLvl1);
                }
            }
        }
        if ($battlesTemp->getCavalryLvl2() > 0)
        {
            foreach ($army as $singleArmy)
            {
                if ($singleArmy->getName() === "Cavalry" && $singleArmy->getLevel() === 2)
                {
                    $amountAfter = $singleArmy->getAmount() - $battlesTemp->getCavalryLvl2();
                    $singleArmy->setAmount($amountAfter);
                    if ($amountAfter === 0)
                    {
                        $this->em->remove($singleArmy);
                    }
                    else
                    {
                        $singleArmy->setAmount($amountAfter);
                    }

                    $cavalryLvl2Stats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Cavalry', 'level' => 2));
                    $cavalryLvl2 = new ArmyBattles();
                    $cavalryLvl2->setAmount($battlesTemp->getCavalryLvl2());
                    $cavalryLvl2->setUserId($battlesTemp->getAttacker());
                    $cavalryLvl2->setBonusVersus($cavalryLvl2Stats->getBonusVersus());
                    $cavalryLvl2->setLevel($cavalryLvl2Stats->getLevel());
                    $cavalryLvl2->setName($cavalryLvl2Stats->getName());
                    $cavalryLvl2->setArmyPicture($singleArmy->getArmyPicture());
                    $cavalryLvl2->setHealth($cavalryLvl2Stats->getHealth());
                    $cavalryLvl2->setDamage($cavalryLvl2Stats->getDamage());
                    $cavalryLvl2->setBonusDamage($cavalryLvl2Stats->getBonusDamage());

                    $this->em->persist($cavalryLvl2);
                    $this->em->flush();

                    $battle->setCavalryLvl2($cavalryLvl2);
                }
            }
        }
        if ($battlesTemp->getCavalryLvl3() > 0)
        {
            foreach ($army as $singleArmy)
            {
                if ($singleArmy->getName() === "Cavalry" && $singleArmy->getLevel() === 3)
                {
                    $amountAfter = $singleArmy->getAmount() - $battlesTemp->getCavalryLvl3();
                    $singleArmy->setAmount($amountAfter);
                    if ($amountAfter === 0)
                    {
                        $this->em->remove($singleArmy);
                    }
                    else
                    {
                        $singleArmy->setAmount($amountAfter);
                    }

                    $cavalryLvl3Stats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Cavalry', 'level' => 3));
                    $cavalryLvl3 = new ArmyBattles();
                    $cavalryLvl3->setAmount($battlesTemp->getCavalryLvl3());
                    $cavalryLvl3->setUserId($battlesTemp->getAttacker());
                    $cavalryLvl3->setBonusVersus($cavalryLvl3Stats->getBonusVersus());
                    $cavalryLvl3->setLevel($cavalryLvl3Stats->getLevel());
                    $cavalryLvl3->setName($cavalryLvl3Stats->getName());
                    $cavalryLvl3->setArmyPicture($singleArmy->getArmyPicture());
                    $cavalryLvl3->setHealth($cavalryLvl3Stats->getHealth());
                    $cavalryLvl3->setDamage($cavalryLvl3Stats->getDamage());
                    $cavalryLvl3->setBonusDamage($cavalryLvl3Stats->getBonusDamage());

                    $this->em->persist($cavalryLvl3);
                    $this->em->flush();

                    $battle->setCavalryLvl3($cavalryLvl3);
                }
            }
        }
        $this->em->persist($battle);
        $this->em->remove($battlesTemp);
        $this->em->flush();
    }

    public function battleCalculationAndArmyReturn()
    {
        $currentDateTime = new \DateTime("now");

        if ($this->em->getRepository(Battles::class)->findAll())
        {
            $battlesToInitiate = $this->em->getRepository(Battles::class)->findAll();

            foreach ($battlesToInitiate as $battleToInitiate)
            {
                if ($currentDateTime > $battleToInitiate->getReachDate())
                {
                    $defender = $this->em->getRepository(User::class)->findOneBy(array('username' => $battleToInitiate->getDefender()));
                    $defenderMainCastle = $this->em->getRepository(Castle::class)->findOneBy(array('userId' => $defender));

                    $count = 1;

                    $defenderArmy = $this->em->getRepository(Army::class)->findBy(array('castleId' => $defenderMainCastle));

                    foreach ($defenderArmy as $defenderArmyOne) {
                        // Footmen Defender
                        if ($defenderArmyOne->getName() == 'Footmen' && $defenderArmyOne->getLevel() == 1) {
                            $defenderFootmenLvl1 = $defenderArmyOne->getAmount();
                        }
                        if ($defenderArmyOne->getName() == 'Footmen' && $defenderArmyOne->getLevel() == 2) {
                            $defenderFootmenLvl2 = $defenderArmyOne->getAmount();
                        }
                        if ($defenderArmyOne->getName() == 'Footmen' && $defenderArmyOne->getLevel() == 3) {
                            $defenderFootmenLvl3 = $defenderArmyOne->getAmount();
                        }

                        // Archers Defender
                        if ($defenderArmyOne->getName() == 'Archers' && $defenderArmyOne->getLevel() == 1) {
                            $defenderArchersLvl1 = $defenderArmyOne->getAmount();
                        }
                        if ($defenderArmyOne->getName() == 'Archers' && $defenderArmyOne->getLevel() == 2) {
                            $defenderArchersLvl2 = $defenderArmyOne->getAmount();
                        }
                        if ($defenderArmyOne->getName() == 'Archers' && $defenderArmyOne->getLevel() == 3) {
                            $defenderArchersLvl3 = $defenderArmyOne->getAmount();
                        }

                        // Cavalry Defender
                        if ($defenderArmyOne->getName() == 'Cavalry' && $defenderArmyOne->getLevel() == 1) {
                            $defenderCavalryLvl1 = $defenderArmyOne->getAmount();
                        }
                        if ($defenderArmyOne->getName() == 'Cavalry' && $defenderArmyOne->getLevel() == 2) {
                            $defenderCavalryLvl2 = $defenderArmyOne->getAmount();
                        }
                        if ($defenderArmyOne->getName() == 'Cavalry' && $defenderArmyOne->getLevel() == 3) {
                            $defenderCavalryLvl3 = $defenderArmyOne->getAmount();
                        }

                    }
                    $attackerArmy = [];
                    array_push($attackerArmy,
                        $battleToInitiate->getFootmenLvl1(),
                        $battleToInitiate->getFootmenLvl2(),
                        $battleToInitiate->getFootmenLvl3(),
                        $battleToInitiate->getArchersLvl1(),
                        $battleToInitiate->getArchersLvl2(),
                        $battleToInitiate->getArchersLvl3(),
                        $battleToInitiate->getCavalryLvl1(),
                        $battleToInitiate->getCavalryLvl2(),
                        $battleToInitiate->getCavalryLvl3());
                    $attackerArmy = array_values(array_filter($attackerArmy));

                    foreach ($attackerArmy as $attackerArmyOne)
                    {
                        /**
                         * @var $attackerArmyOne ArmyBattles
                         */

                        // Footmen Attacker
                        if ($attackerArmyOne->getName() == 'Footmen' && $attackerArmyOne->getLevel() == 1)
                        {
                            $attackerFootmenLvl1 = $attackerArmyOne->getAmount();
                        }
                        if ($attackerArmyOne->getName() == 'Footmen' && $attackerArmyOne->getLevel() == 2)
                        {
                            $attackerFootmenLvl2 = $attackerArmyOne->getAmount();
                        }
                        if ($attackerArmyOne->getName() == 'Footmen' && $attackerArmyOne->getLevel() == 3)
                        {
                            $attackerFootmenLvl3 = $attackerArmyOne->getAmount();
                        }

                        // Archers Attacker
                        if ($attackerArmyOne->getName() == 'Archers' && $attackerArmyOne->getLevel() == 1)
                        {
                            $attackerArchersLvl1 = $attackerArmyOne->getAmount();
                        }
                        if ($attackerArmyOne->getName() == 'Archers' && $attackerArmyOne->getLevel() == 2)
                        {
                            $attackerArchersLvl2 = $attackerArmyOne->getAmount();
                        }
                        if ($attackerArmyOne->getName() == 'Archers' && $attackerArmyOne->getLevel() == 3)
                        {
                            $attackerArchersLvl3 = $attackerArmyOne->getAmount();
                        }

                        // Cavalry Attacker
                        if ($attackerArmyOne->getName() == 'Cavalry' && $attackerArmyOne->getLevel() == 1)
                        {
                            $attackerCavalryLvl1 = $attackerArmyOne->getAmount();
                        }
                        if ($attackerArmyOne->getName() == 'Cavalry' && $attackerArmyOne->getLevel() == 2)
                        {
                            $attackerCavalryLvl2 = $attackerArmyOne->getAmount();
                        }
                        if ($attackerArmyOne->getName() == 'Cavalry' && $attackerArmyOne->getLevel() == 3)
                        {
                            $attackerCavalryLvl3 = $attackerArmyOne->getAmount();
                        }
                    }


                    if ($defenderMainCastle->getCastleLvl() == 0) {
                        $additionalHealthFromCastle = 0;
                    } elseif ($defenderMainCastle->getCastleLvl() == 1) {
                        $additionalHealthFromCastle = 100;
                    } elseif ($defenderMainCastle->getCastleLvl() == 2) {
                        $additionalHealthFromCastle = 250;
                    } elseif ($defenderMainCastle->getCastleLvl() == 3) {
                        $additionalHealthFromCastle = 500;
                    }

                    while (true)
                    {
                        $a = array_rand($attackerArmy, 1);
                        /**
                         * @var ArmyBattles $attackerArmyFirst
                         */
                        $attackerArmyFirst = $attackerArmy[$a];
                        $attackerArmyHP = $attackerArmyFirst->getAmount() * $attackerArmyFirst->getHealth();

                        if ($defenderArmy)
                        {
                            $b = array_rand($defenderArmy, 1);
                            $defenderArmyFirst = $defenderArmy[$b];

                            if ($count == 1)
                            {
                                $defenderArmyHP = $defenderArmyFirst->getAmount() * $defenderArmyFirst->getHealth() + $additionalHealthFromCastle;
                            }
                            elseif ($count > 1)
                            {
                                $defenderArmyHP = $defenderArmyFirst->getAmount() * $defenderArmyFirst->getHealth();
                            }

                            if ($defenderArmyFirst->getBonusVersus() == $attackerArmyFirst->getName())
                            {
                                $defenderArmyDamage = $defenderArmyFirst->getAmount() * ($defenderArmyFirst->getDamage() + $defenderArmyFirst->getBonusDamage());
                            }
                            else
                            {
                                $defenderArmyDamage = $defenderArmyFirst->getAmount() * $defenderArmyFirst->getDamage();
                            }

                            if ($attackerArmyFirst->getBonusVersus() == $defenderArmyFirst->getName())
                            {
                                $attackerArmyDamage = $attackerArmyFirst->getAmount() * ($attackerArmyFirst->getDamage() + $attackerArmyFirst->getBonusDamage());
                            }
                            else
                            {
                                $attackerArmyDamage = $attackerArmyFirst->getAmount() * $attackerArmyFirst->getDamage();
                            }
                        }
                        else
                        {
                            $defenderArmyFirst = null;
                            $defenderArmyHP = 0;
                            $defenderArmyDamage = 0;
                            $attackerArmyDamage = $attackerArmyFirst->getAmount() * $attackerArmyFirst->getDamage();
                        }


                        $count++;

                        while (true)
                        {
                            $defenderArmyHPTemp = $defenderArmyHP - $attackerArmyDamage;
                            $attackerArmyHPTemp = $attackerArmyHP - $defenderArmyDamage;
                            $defenderArmyHP = $defenderArmyHPTemp;
                            $attackerArmyHP = $attackerArmyHPTemp;
                            if ($defenderArmyHP <= 0 && $attackerArmyHP <= 0)
                            {
                                unset($defenderArmy[$b]);
                                unset($attackerArmy[$a]);
                                break;
                            }
                            else
                            {
                                if ($defenderArmyHP <= 0)
                                {
                                    if ($defenderArmy)
                                    {
                                        unset($defenderArmy[$b]);
                                    }
                                    $attackerArmyFirst->setAmount((int)ceil($attackerArmyHP / $attackerArmyFirst->getHealth()));
                                    break;
                                }
                                elseif ($attackerArmyHP <= 0)
                                {
                                    unset($attackerArmy[$a]);
                                    $defenderArmyFirst->setAmount((int)ceil($defenderArmyHP / $defenderArmyFirst->getHealth()));
                                    break;
                                }
                            }
                        }

                        if (empty($attackerArmy) && empty($defenderArmy))
                        {
                            $battleReport = new BattleReports();
                            $battleReport->setAttacker($battleToInitiate->getAttacker()->getUsername());
                            $battleReport->setDefender($battleToInitiate->getDefender());
                            $battleReport->setReturnDate($battleToInitiate->getReturnDate());
                            $battleReport->setWinner($battleToInitiate->getDefender());
                            $battleReport->setBattleDate($battleToInitiate->getReachDate());
                            $battleReport->setCastleId($battleToInitiate->getCastleId());
                            $battleReport->setArmyReturnedToCastle(true);

                            $this->em->remove($battleToInitiate);
                            // Attacker

                            // Footmen Attacker
                            if ($battleToInitiate->getFootmenLvl1())
                            {
                                $battleReport->setAttackerDeadFootmenLvl1($battleToInitiate->getFootmenLvl1()->getAmount());
                                $footmenLvl1Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getFootmenLvl1()));
                                $this->em->remove($footmenLvl1Obj);
                            }
                            if ($battleToInitiate->getFootmenLvl2())
                            {
                                $battleReport->setAttackerDeadFootmenLvl2($battleToInitiate->getFootmenLvl2()->getAmount());
                                $footmenLvl2Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getFootmenLvl2()));
                                $this->em->remove($footmenLvl2Obj);
                            }
                            if ($battleToInitiate->getFootmenLvl3())
                            {
                                $battleReport->setAttackerDeadFootmenLvl3($battleToInitiate->getFootmenLvl3()->getAmount());
                                $footmenLvl3Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getFootmenLvl3()));
                                $this->em->remove($footmenLvl3Obj);
                            }

                            // Archers Attacker
                            if ($battleToInitiate->getArchersLvl1())
                            {
                                $battleReport->setAttackerDeadArchersLvl1($battleToInitiate->getArchersLvl1()->getAmount());
                                $archersLvl1Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getArchersLvl1()));
                                $this->em->remove($archersLvl1Obj);
                            }
                            if ($battleToInitiate->getArchersLvl2())
                            {
                                $battleReport->setAttackerDeadArchersLvl2($battleToInitiate->getArchersLvl2()->getAmount());
                                $archersLvl2Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getArchersLvl2()));
                                $this->em->remove($archersLvl2Obj);
                            }
                            if ($battleToInitiate->getArchersLvl3())
                            {
                                $battleReport->setAttackerDeadArchersLvl3($battleToInitiate->getArchersLvl3()->getAmount());
                                $archersLvl3Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getArchersLvl3()));
                                $this->em->remove($archersLvl3Obj);
                            }

                            // Cavalry Attacker
                            if ($battleToInitiate->getCavalryLvl1())
                            {
                                $battleReport->setAttackerDeadCavalryLvl1($battleToInitiate->getCavalryLvl1()->getAmount());
                                $cavalryLvl1Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getCavalryLvl1()));
                                $this->em->remove($cavalryLvl1Obj);
                            }
                            if ($battleToInitiate->getCavalryLvl2())
                            {
                                $battleReport->setAttackerDeadCavalryLvl2($battleToInitiate->getCavalryLvl2()->getAmount());
                                $cavalryLvl2Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getCavalryLvl2()));
                                $this->em->remove($cavalryLvl2Obj);
                            }
                            if ($battleToInitiate->getCavalryLvl3())
                            {
                                $battleReport->setAttackerDeadCavalryLvl3($battleToInitiate->getCavalryLvl3()->getAmount());
                                $cavalryLvl3Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getCavalryLvl3()));
                                $this->em->remove($cavalryLvl3Obj);
                            }

                            // Defender

                            $defenderArmyBefore = $this->em->getRepository(Army::class)->findBy(array('castleId' => $defenderMainCastle));

                            foreach ($defenderArmyBefore as $defenderArmyBeforeOne)
                            {
                                // Footmen Defender
                                if ($defenderArmyBeforeOne->getName() == 'Footmen' && $defenderArmyBeforeOne->getLevel() == 1)
                                {
                                    $battleReport->setDefenderDeadFootmenLvl1($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                                if ($defenderArmyBeforeOne->getName() == 'Footmen' && $defenderArmyBeforeOne->getLevel() == 2)
                                {
                                    $battleReport->setDefenderDeadFootmenLvl2($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                                if ($defenderArmyBeforeOne->getName() == 'Footmen' && $defenderArmyBeforeOne->getLevel() == 3)
                                {
                                    $battleReport->setDefenderDeadFootmenLvl3($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }

                                // Archers Defender
                                if ($defenderArmyBeforeOne->getName() == 'Archers' && $defenderArmyBeforeOne->getLevel() == 1)
                                {
                                    $battleReport->setDefenderDeadArchersLvl1($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                                if ($defenderArmyBeforeOne->getName() == 'Archers' && $defenderArmyBeforeOne->getLevel() == 2)
                                {
                                    $battleReport->setDefenderDeadArchersLvl2($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                                if ($defenderArmyBeforeOne->getName() == 'Archers' && $defenderArmyBeforeOne->getLevel() == 3)
                                {
                                    $battleReport->setDefenderDeadArchersLvl3($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }

                                // Cavalry Defender
                                if ($defenderArmyBeforeOne->getName() == 'Cavalry' && $defenderArmyBeforeOne->getLevel() == 1)
                                {
                                    $battleReport->setDefenderDeadCavalryLvl1($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                                if ($defenderArmyBeforeOne->getName() == 'Cavalry' && $defenderArmyBeforeOne->getLevel() == 2)
                                {
                                    $battleReport->setDefenderDeadCavalryLvl2($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                                if ($defenderArmyBeforeOne->getName() == 'Cavalry' && $defenderArmyBeforeOne->getLevel() == 3)
                                {
                                    $battleReport->setDefenderDeadCavalryLvl3($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                            }

                            $this->em->persist($battleReport);

                            $this->em->flush();
                            break;
                        }
                        elseif (empty($attackerArmy))
                        {
                            $battleReport = new BattleReports();
                            $battleReport->setAttacker($battleToInitiate->getAttacker()->getUsername());
                            $battleReport->setDefender($battleToInitiate->getDefender());
                            $battleReport->setReturnDate($battleToInitiate->getReturnDate());
                            $battleReport->setWinner($battleToInitiate->getDefender());
                            $battleReport->setBattleDate($battleToInitiate->getReachDate());
                            $battleReport->setCastleId($battleToInitiate->getCastleId());
                            $battleReport->setArmyReturnedToCastle(true);

                            $this->em->remove($battleToInitiate);
                            // Attacker

                            // Footmen Attacker
                            if ($battleToInitiate->getFootmenLvl1())
                            {
                                $battleReport->setAttackerDeadFootmenLvl1($battleToInitiate->getFootmenLvl1()->getAmount());
                                $footmenLvl1Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getFootmenLvl1()));
                                $this->em->remove($footmenLvl1Obj);
                            }
                            if ($battleToInitiate->getFootmenLvl2())
                            {
                                $battleReport->setAttackerDeadFootmenLvl2($battleToInitiate->getFootmenLvl2()->getAmount());
                                $footmenLvl2Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getFootmenLvl2()));
                                $this->em->remove($footmenLvl2Obj);
                            }
                            if ($battleToInitiate->getFootmenLvl3())
                            {
                                $battleReport->setAttackerDeadFootmenLvl3($battleToInitiate->getFootmenLvl3()->getAmount());
                                $footmenLvl3Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getFootmenLvl3()));
                                $this->em->remove($footmenLvl3Obj);
                            }

                            // Archers Attacker
                            if ($battleToInitiate->getArchersLvl1())
                            {
                                $battleReport->setAttackerDeadArchersLvl1($battleToInitiate->getArchersLvl1()->getAmount());
                                $archersLvl1Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getArchersLvl1()));
                                $this->em->remove($archersLvl1Obj);
                            }
                            if ($battleToInitiate->getArchersLvl2())
                            {
                                $battleReport->setAttackerDeadArchersLvl2($battleToInitiate->getArchersLvl2()->getAmount());
                                $archersLvl2Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getArchersLvl2()));
                                $this->em->remove($archersLvl2Obj);
                            }
                            if ($battleToInitiate->getArchersLvl3())
                            {
                                $battleReport->setAttackerDeadArchersLvl3($battleToInitiate->getArchersLvl3()->getAmount());
                                $archersLvl3Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getArchersLvl3()));
                                $this->em->remove($archersLvl3Obj);
                            }

                            // Cavalry Attacker
                            if ($battleToInitiate->getCavalryLvl1())
                            {
                                $battleReport->setAttackerDeadCavalryLvl1($battleToInitiate->getCavalryLvl1()->getAmount());
                                $cavalryLvl1Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getCavalryLvl1()));
                                $this->em->remove($cavalryLvl1Obj);
                            }
                            if ($battleToInitiate->getCavalryLvl2())
                            {
                                $battleReport->setAttackerDeadCavalryLvl2($battleToInitiate->getCavalryLvl2()->getAmount());
                                $cavalryLvl2Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getCavalryLvl2()));
                                $this->em->remove($cavalryLvl2Obj);
                            }
                            if ($battleToInitiate->getCavalryLvl3())
                            {
                                $battleReport->setAttackerDeadCavalryLvl3($battleToInitiate->getCavalryLvl3()->getAmount());
                                $cavalryLvl3Obj = $this->em->getRepository(ArmyBattles::class)->findOneBy(array('id' => $battleToInitiate->getCavalryLvl3()));
                                $this->em->remove($cavalryLvl3Obj);
                            }

                            // Defender

                            foreach ($defenderArmy as $defenderArmyOne)
                            {
                                // Footmen Defender
                                if ($defenderArmyOne->getName() == 'Footmen' && $defenderArmyOne->getLevel() == 1)
                                {
                                    $battleReport->setDefenderRemainingFootmenLvl1($defenderArmyOne->getAmount());
                                    if ($defenderFootmenLvl1)
                                    {
                                        $battleReport->setDefenderDeadFootmenLvl1($defenderFootmenLvl1 - $defenderArmyOne->getAmount());
                                    }
                                }
                                if ($defenderArmyOne->getName() == 'Footmen' && $defenderArmyOne->getLevel() == 2)
                                {
                                    $battleReport->setDefenderRemainingFootmenLvl2($defenderArmyOne->getAmount());
                                    if ($defenderFootmenLvl2)
                                    {
                                        $battleReport->setDefenderDeadFootmenLvl2($defenderFootmenLvl2 - $defenderArmyOne->getAmount());
                                    }
                                }
                                if ($defenderArmyOne->getName() == 'Footmen' && $defenderArmyOne->getLevel() == 3)
                                {
                                    $battleReport->setDefenderRemainingFootmenLvl3($defenderArmyOne->getAmount());
                                    if ($defenderFootmenLvl3)
                                    {
                                        $battleReport->setDefenderDeadFootmenLvl3($defenderFootmenLvl3 - $defenderArmyOne->getAmount());
                                    }
                                }

                                // Archers Defender
                                if ($defenderArmyOne->getName() == 'Archers' && $defenderArmyOne->getLevel() == 1)
                                {
                                    $battleReport->setDefenderRemainingArchersLvl1($defenderArmyOne->getAmount());
                                    if ($defenderArchersLvl1)
                                    {
                                        $battleReport->setDefenderDeadArchersLvl1($defenderArchersLvl1 - $defenderArmyOne->getAmount());
                                    }
                                }
                                if ($defenderArmyOne->getName() == 'Archers' && $defenderArmyOne->getLevel() == 2)
                                {
                                    $battleReport->setDefenderRemainingArchersLvl2($defenderArmyOne->getAmount());
                                    if ($defenderArchersLvl2)
                                    {
                                        $battleReport->setDefenderDeadArchersLvl2($defenderArchersLvl2 - $defenderArmyOne->getAmount());
                                    }
                                }
                                if ($defenderArmyOne->getName() == 'Archers' && $defenderArmyOne->getLevel() == 3)
                                {
                                    $battleReport->setDefenderRemainingArchersLvl3($defenderArmyOne->getAmount());
                                    if ($defenderArchersLvl3)
                                    {
                                        $battleReport->setDefenderDeadArchersLvl3($defenderArchersLvl3 - $defenderArmyOne->getAmount());
                                    }
                                }

                                // Cavalry Defender
                                if ($defenderArmyOne->getName() == 'Cavalry' && $defenderArmyOne->getLevel() == 1)
                                {
                                    $battleReport->setDefenderRemainingCavalryLvl1($defenderArmyOne->getAmount());
                                    if ($defenderCavalryLvl1)
                                    {
                                        $battleReport->setDefenderDeadCavalryLvl1($defenderCavalryLvl1 - $defenderArmyOne->getAmount());
                                    }
                                }
                                if ($defenderArmyOne->getName() == 'Cavalry' && $defenderArmyOne->getLevel() == 2)
                                {
                                    $battleReport->setDefenderRemainingCavalryLvl2($defenderArmyOne->getAmount());
                                    if ($defenderCavalryLvl2)
                                    {
                                        $battleReport->setDefenderDeadCavalryLvl2($defenderCavalryLvl2 - $defenderArmyOne->getAmount());
                                    }
                                }
                                if ($defenderArmyOne->getName() == 'Cavalry' && $defenderArmyOne->getLevel() == 3)
                                {
                                    $battleReport->setDefenderRemainingCavalryLvl3($defenderArmyOne->getAmount());
                                    if ($defenderCavalryLvl3)
                                    {
                                        $battleReport->setDefenderDeadCavalryLvl3($defenderCavalryLvl3 - $defenderArmyOne->getAmount());
                                    }
                                }
                            }

                            $this->em->persist($battleReport);
                            $this->em->flush();
                            break;
                        }
                        elseif (empty($defenderArmy))
                        {
                            $battleReport = new BattleReports();
                            $battleReport->setAttacker($battleToInitiate->getAttacker()->getUsername());
                            $battleReport->setDefender($battleToInitiate->getDefender());
                            $battleReport->setReturnDate($battleToInitiate->getReturnDate());
                            $battleReport->setWinner($battleToInitiate->getAttacker()->getUsername());
                            $battleReport->setBattleDate($battleToInitiate->getReachDate());
                            $battleReport->setCastleId($battleToInitiate->getCastleId());

                            $battleReport->setGainedFood((int)round($defender->getFood() * 0.1 + 100));
                            $defender->setFood((int)round($defender->getFood() * 0.9));

                            $battleReport->setGainedMetal((int)round($defender->getMetal() * 0.1 + 100));
                            $defender->setMetal((int)round($defender->getMetal() * 0.9));
                            $this->em->persist($defender);

                            // Attacker

                            foreach ($attackerArmy as $attackerArmyOne)
                            {
                                /**
                                 * @var ArmyBattles $attackerArmyOne
                                 * @var ArmyBattles $attackerArmyBeforeOne
                                 */

                                // Footmen Attacker
                                if ($attackerArmyOne->getName() == "Footmen" && $attackerArmyOne->getLevel() == 1)
                                {
                                    $battleReport->setAttackerRemainingFootmenLvl1($attackerArmyOne->getAmount());
                                    if ($attackerFootmenLvl1)
                                    {
                                        $battleReport->setAttackerDeadFootmenLvl1($attackerFootmenLvl1 - $attackerArmyOne->getAmount());
                                    }
                                }
                                if ($attackerArmyOne->getName() == "Footmen" && $attackerArmyOne->getLevel() == 2)
                                {
                                    $battleReport->setAttackerRemainingFootmenLvl2($attackerArmyOne->getAmount());
                                    if ($attackerFootmenLvl2)
                                    {
                                        $battleReport->setAttackerDeadFootmenLvl2($attackerFootmenLvl2 - $attackerArmyOne->getAmount());
                                    }
                                }
                                if ($attackerArmyOne->getName() == "Footmen" && $attackerArmyOne->getLevel() == 3)
                                {
                                    $battleReport->setAttackerRemainingFootmenLvl3($attackerArmyOne->getAmount());
                                    if ($attackerFootmenLvl3)
                                    {
                                        $battleReport->setAttackerDeadFootmenLvl3($attackerFootmenLvl3 - $attackerArmyOne->getAmount());
                                    }
                                }

                                // Archers Attacker
                                if ($attackerArmyOne->getName() == "Archers" && $attackerArmyOne->getLevel() == 1)
                                {
                                    $battleReport->setAttackerRemainingArchersLvl1($attackerArmyOne->getAmount());
                                    if ($attackerArchersLvl1)
                                    {
                                        $battleReport->setAttackerDeadArchersLvl1($attackerArchersLvl1 - $attackerArmyOne->getAmount());
                                    }
                                }
                                if ($attackerArmyOne->getName() == "Archers" && $attackerArmyOne->getLevel() == 2)
                                {
                                    $battleReport->setAttackerRemainingArchersLvl2($attackerArmyOne->getAmount());
                                    if ($attackerArchersLvl2)
                                    {
                                        $battleReport->setAttackerDeadArchersLvl2($attackerArchersLvl2 - $attackerArmyOne->getAmount());
                                    }
                                }
                                if ($attackerArmyOne->getName() == "Archers" && $attackerArmyOne->getLevel() == 3)
                                {
                                    $battleReport->setAttackerRemainingArchersLvl3($attackerArmyOne->getAmount());
                                    if ($attackerArchersLvl3)
                                    {
                                        $battleReport->setAttackerDeadArchersLvl3($attackerArchersLvl3 - $attackerArmyOne->getAmount());
                                    }
                                }

                                // Cavalry Attacker
                                if ($attackerArmyOne->getName() == "Cavalry" && $attackerArmyOne->getLevel() == 1)
                                {
                                    $battleReport->setAttackerRemainingCavalryLvl1($attackerArmyOne->getAmount());
                                    if ($attackerCavalryLvl1)
                                    {
                                        $battleReport->setAttackerDeadCavalryLvl1($attackerCavalryLvl1 - $attackerArmyOne->getAmount());
                                    }
                                }
                                if ($attackerArmyOne->getName() == "Cavalry" && $attackerArmyOne->getLevel() == 2)
                                {
                                    $battleReport->setAttackerRemainingCavalryLvl2($attackerArmyOne->getAmount());
                                    if ($attackerCavalryLvl2)
                                    {
                                        $battleReport->setAttackerDeadCavalryLvl2($attackerCavalryLvl2 - $attackerArmyOne->getAmount());
                                    }
                                }
                                if ($attackerArmyOne->getName() == "Cavalry" && $attackerArmyOne->getLevel() == 3)
                                {
                                    $battleReport->setAttackerRemainingCavalryLvl3($attackerArmyOne->getAmount());
                                    if ($attackerCavalryLvl3)
                                    {
                                        $battleReport->setAttackerDeadCavalryLvl3($attackerCavalryLvl3 - $attackerArmyOne->getAmount());
                                    }
                                }
                            }

                            // Defender

                            $defenderArmyBefore = $this->em->getRepository(Army::class)->findBy(array('castleId' => $defenderMainCastle));

                            foreach ($defenderArmyBefore as $defenderArmyBeforeOne)
                            {
                                // Footmen Defender
                                if ($defenderArmyBeforeOne->getName() == 'Footmen' && $defenderArmyBeforeOne->getLevel() == 1)
                                {
                                    $battleReport->setDefenderDeadFootmenLvl1($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                                if ($defenderArmyBeforeOne->getName() == 'Footmen' && $defenderArmyBeforeOne->getLevel() == 2)
                                {
                                    $battleReport->setDefenderDeadFootmenLvl2($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                                if ($defenderArmyBeforeOne->getName() == 'Footmen' && $defenderArmyBeforeOne->getLevel() == 3)
                                {
                                    $battleReport->setDefenderDeadFootmenLvl3($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }

                                // Archers Defender
                                if ($defenderArmyBeforeOne->getName() == 'Archers' && $defenderArmyBeforeOne->getLevel() == 1)
                                {
                                    $battleReport->setDefenderDeadArchersLvl1($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                                if ($defenderArmyBeforeOne->getName() == 'Archers' && $defenderArmyBeforeOne->getLevel() == 2)
                                {
                                    $battleReport->setDefenderDeadArchersLvl2($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                                if ($defenderArmyBeforeOne->getName() == 'Archers' && $defenderArmyBeforeOne->getLevel() == 3)
                                {
                                    $battleReport->setDefenderDeadArchersLvl3($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }

                                // Cavalry Defender
                                if ($defenderArmyBeforeOne->getName() == 'Cavalry' && $defenderArmyBeforeOne->getLevel() == 1)
                                {
                                    $battleReport->setDefenderDeadCavalryLvl1($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                                if ($defenderArmyBeforeOne->getName() == 'Cavalry' && $defenderArmyBeforeOne->getLevel() == 2)
                                {
                                    $battleReport->setDefenderDeadCavalryLvl2($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                                if ($defenderArmyBeforeOne->getName() == 'Cavalry' && $defenderArmyBeforeOne->getLevel() == 3)
                                {
                                    $battleReport->setDefenderDeadCavalryLvl3($defenderArmyBeforeOne->getAmount());
                                    $this->em->remove($defenderArmyBeforeOne);
                                    $this->em->flush();
                                }
                            }

                            $this->em->persist($battleReport);
                            $this->em->remove($battleToInitiate);
                            $this->em->flush();
                            break;
                        }
                    }
                }
            }
        }

        if ($this->em->getRepository(BattleReports::class)->findBy(array('armyReturnedToCastle' => false)))
        {
            $battleReports = $this->em->getRepository(BattleReports::class)->findBy(array('armyReturnedToCastle' => false));

            foreach ($battleReports as $battleReport)
            {
                if ($battleReport->getReturnDate() < $currentDateTime && $battleReport->isArmyReturnedToCastle() == false)
                {
                    $castleToReturnArmyTo = $this->em->getRepository(Castle::class)->findOneBy(array('id' => $battleReport->getCastleId()));
                    $userToGainResources = $this->em->getRepository(User::class)->findOneBy(array('id' => $castleToReturnArmyTo->getUserId()));
                    $userToGainResources->setFood($userToGainResources->getFood() + $battleReport->getGainedFood());
                    $userToGainResources->setMetal($userToGainResources->getMetal() + $battleReport->getGainedMetal());
                    $this->em->persist($userToGainResources);
                    $this->em->flush();

                    $castleArmyToReturnArmyTo = $this->em->getRepository(Army::class)->findBy(array('castleId' => $castleToReturnArmyTo));

                // Footmen

                    // Level 1
                    if ($battleReport->getAttackerRemainingFootmenLvl1() > 0)
                    {
                        $isFound = false;
                        foreach ($castleArmyToReturnArmyTo as $castleArmyToReturnArmyToOne)
                        {
                            if ($castleArmyToReturnArmyToOne->getName() == 'Footmen' && $castleArmyToReturnArmyToOne->getLevel() == 1)
                            {
                                $isFound = true;
                                $castleArmyToReturnArmyToOne->setAmount($castleArmyToReturnArmyToOne->getAmount() + $battleReport->getAttackerRemainingFootmenLvl1());
                                $this->em->persist($castleArmyToReturnArmyToOne);
                                $this->em->flush();
                            }
                        }
                        if ($isFound == false)
                        {
                            $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Footmen', 'level' => 1));
                            $armyCreate = new Army();
                            $armyCreate->setCastleId($castleToReturnArmyTo);
                            $armyCreate->setAmount($battleReport->getAttackerRemainingFootmenLvl1());
                            $armyCreate->setName($armyStats->getName());
                            $armyCreate->setLevel($armyStats->getLevel());
                            $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                            $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                            $armyCreate->setDamage($armyStats->getDamage());
                            $armyCreate->setHealth($armyStats->getHealth());

                            if ($castleToReturnArmyTo->getName() == 'Dwarf')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Elfs')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Mages')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Ninja')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Olymp')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Vampire')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireFootmen.jpg');
                            }
                            $this->em->persist($armyCreate);
                            $this->em->flush();
                        }
                    }

                    // Level 2
                    if ($battleReport->getAttackerRemainingFootmenLvl2() > 0)
                    {
                        $isFound = false;
                        foreach ($castleArmyToReturnArmyTo as $castleArmyToReturnArmyToOne)
                        {
                            if ($castleArmyToReturnArmyToOne->getName() == 'Footmen' && $castleArmyToReturnArmyToOne->getLevel() == 2)
                            {
                                $isFound = true;
                                $castleArmyToReturnArmyToOne->setAmount($castleArmyToReturnArmyToOne->getAmount() + $battleReport->getAttackerRemainingFootmenLvl2());
                                $this->em->persist($castleArmyToReturnArmyToOne);
                                $this->em->flush();
                            }
                        }
                        if ($isFound == false)
                        {
                            $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Footmen', 'level' => 2));
                            $armyCreate = new Army();
                            $armyCreate->setCastleId($castleToReturnArmyTo);
                            $armyCreate->setAmount($battleReport->getAttackerRemainingFootmenLvl2());
                            $armyCreate->setName($armyStats->getName());
                            $armyCreate->setLevel($armyStats->getLevel());
                            $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                            $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                            $armyCreate->setDamage($armyStats->getDamage());
                            $armyCreate->setHealth($armyStats->getHealth());

                            if ($castleToReturnArmyTo->getName() == 'Dwarf')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Elfs')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Mages')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Ninja')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Olymp')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Vampire')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireFootmen.jpg');
                            }
                            $this->em->persist($armyCreate);
                            $this->em->flush();
                        }
                    }

                    // Level 3
                    if ($battleReport->getAttackerRemainingFootmenLvl3() > 0)
                    {
                        $isFound = false;
                        foreach ($castleArmyToReturnArmyTo as $castleArmyToReturnArmyToOne)
                        {
                            if ($castleArmyToReturnArmyToOne->getName() == 'Footmen' && $castleArmyToReturnArmyToOne->getLevel() == 3)
                            {
                                $isFound = true;
                                $castleArmyToReturnArmyToOne->setAmount($castleArmyToReturnArmyToOne->getAmount() + $battleReport->getAttackerRemainingFootmenLvl3());
                                $this->em->persist($castleArmyToReturnArmyToOne);
                                $this->em->flush();
                            }
                        }
                        if ($isFound == false)
                        {
                            $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Footmen', 'level' => 3));
                            $armyCreate = new Army();
                            $armyCreate->setCastleId($castleToReturnArmyTo);
                            $armyCreate->setAmount($battleReport->getAttackerRemainingFootmenLvl3());
                            $armyCreate->setName($armyStats->getName());
                            $armyCreate->setLevel($armyStats->getLevel());
                            $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                            $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                            $armyCreate->setDamage($armyStats->getDamage());
                            $armyCreate->setHealth($armyStats->getHealth());

                            if ($castleToReturnArmyTo->getName() == 'Dwarf')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Elfs')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Mages')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Ninja')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Olymp')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympFootmen.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Vampire')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireFootmen.jpg');
                            }
                            $this->em->persist($armyCreate);
                            $this->em->flush();
                        }
                    }

                // Archers

                    // Level 1
                    if ($battleReport->getAttackerRemainingArchersLvl1() > 0)
                    {
                        $isFound = false;
                        foreach ($castleArmyToReturnArmyTo as $castleArmyToReturnArmyToOne)
                        {
                            if ($castleArmyToReturnArmyToOne->getName() == 'Archers' && $castleArmyToReturnArmyToOne->getLevel() == 1)
                            {
                                $isFound = true;
                                $castleArmyToReturnArmyToOne->setAmount($castleArmyToReturnArmyToOne->getAmount() + $battleReport->getAttackerRemainingArchersLvl1());
                                $this->em->persist($castleArmyToReturnArmyToOne);
                                $this->em->flush();
                            }
                        }
                        if ($isFound == false)
                        {
                            $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Archers', 'level' => 1));
                            $armyCreate = new Army();
                            $armyCreate->setCastleId($castleToReturnArmyTo);
                            $armyCreate->setAmount($battleReport->getAttackerRemainingArchersLvl1());
                            $armyCreate->setName($armyStats->getName());
                            $armyCreate->setLevel($armyStats->getLevel());
                            $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                            $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                            $armyCreate->setDamage($armyStats->getDamage());
                            $armyCreate->setHealth($armyStats->getHealth());

                            if ($castleToReturnArmyTo->getName() == 'Dwarf')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Elfs')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Mages')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Ninja')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Olymp')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Vampire')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireArchers.jpg');
                            }
                            $this->em->persist($armyCreate);
                            $this->em->flush();
                        }
                    }

                    // Level 2
                    if ($battleReport->getAttackerRemainingArchersLvl2() > 0)
                    {
                        $isFound = false;
                        foreach ($castleArmyToReturnArmyTo as $castleArmyToReturnArmyToOne)
                        {
                            if ($castleArmyToReturnArmyToOne->getName() == 'Archers' && $castleArmyToReturnArmyToOne->getLevel() == 2)
                            {
                                $isFound = true;
                                $castleArmyToReturnArmyToOne->setAmount($castleArmyToReturnArmyToOne->getAmount() + $battleReport->getAttackerRemainingArchersLvl2());
                                $this->em->persist($castleArmyToReturnArmyToOne);
                                $this->em->flush();
                            }
                        }
                        if ($isFound == false)
                        {
                            $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Archers', 'level' => 2));
                            $armyCreate = new Army();
                            $armyCreate->setCastleId($castleToReturnArmyTo);
                            $armyCreate->setAmount($battleReport->getAttackerRemainingArchersLvl2());
                            $armyCreate->setName($armyStats->getName());
                            $armyCreate->setLevel($armyStats->getLevel());
                            $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                            $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                            $armyCreate->setDamage($armyStats->getDamage());
                            $armyCreate->setHealth($armyStats->getHealth());

                            if ($castleToReturnArmyTo->getName() == 'Dwarf')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Elfs')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Mages')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Ninja')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Olymp')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Vampire')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireArchers.jpg');
                            }
                            $this->em->persist($armyCreate);
                            $this->em->flush();
                        }
                    }

                    // Level 3
                    if ($battleReport->getAttackerRemainingArchersLvl3() > 0)
                    {
                        $isFound = false;
                        foreach ($castleArmyToReturnArmyTo as $castleArmyToReturnArmyToOne)
                        {
                            if ($castleArmyToReturnArmyToOne->getName() == 'Archers' && $castleArmyToReturnArmyToOne->getLevel() == 3)
                            {
                                $isFound = true;
                                $castleArmyToReturnArmyToOne->setAmount($castleArmyToReturnArmyToOne->getAmount() + $battleReport->getAttackerRemainingArchersLvl3());
                                $this->em->persist($castleArmyToReturnArmyToOne);
                                $this->em->flush();
                            }
                        }
                        if ($isFound == false)
                        {
                            $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Archers', 'level' => 3));
                            $armyCreate = new Army();
                            $armyCreate->setCastleId($castleToReturnArmyTo);
                            $armyCreate->setAmount($battleReport->getAttackerRemainingArchersLvl3());
                            $armyCreate->setName($armyStats->getName());
                            $armyCreate->setLevel($armyStats->getLevel());
                            $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                            $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                            $armyCreate->setDamage($armyStats->getDamage());
                            $armyCreate->setHealth($armyStats->getHealth());

                            if ($castleToReturnArmyTo->getName() == 'Dwarf')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Elfs')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Mages')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Ninja')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Olymp')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympArchers.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Vampire')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireArchers.jpg');
                            }
                            $this->em->persist($armyCreate);
                            $this->em->flush();
                        }
                    }

                // Cavalry

                    // Level 1
                    if ($battleReport->getAttackerRemainingCavalryLvl1() > 0)
                    {
                        $isFound = false;
                        foreach ($castleArmyToReturnArmyTo as $castleArmyToReturnArmyToOne)
                        {
                            if ($castleArmyToReturnArmyToOne->getName() == 'Cavalry' && $castleArmyToReturnArmyToOne->getLevel() == 1)
                            {
                                $isFound = true;
                                $castleArmyToReturnArmyToOne->setAmount($castleArmyToReturnArmyToOne->getAmount() + $battleReport->getAttackerRemainingCavalryLvl1());
                                $this->em->persist($castleArmyToReturnArmyToOne);
                                $this->em->flush();
                            }
                        }
                        if ($isFound == false)
                        {
                            $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Cavalry', 'level' => 1));
                            $armyCreate = new Army();
                            $armyCreate->setCastleId($castleToReturnArmyTo);
                            $armyCreate->setAmount($battleReport->getAttackerRemainingCavalryLvl1());
                            $armyCreate->setName($armyStats->getName());
                            $armyCreate->setLevel($armyStats->getLevel());
                            $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                            $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                            $armyCreate->setDamage($armyStats->getDamage());
                            $armyCreate->setHealth($armyStats->getHealth());

                            if ($castleToReturnArmyTo->getName() == 'Dwarf')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Elfs')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Mages')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Ninja')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Olymp')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Vampire')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireCavalry.jpg');
                            }
                            $this->em->persist($armyCreate);
                            $this->em->flush();
                        }
                    }

                    // Level 2
                    if ($battleReport->getAttackerRemainingCavalryLvl2() > 0)
                    {
                        $isFound = false;
                        foreach ($castleArmyToReturnArmyTo as $castleArmyToReturnArmyToOne)
                        {
                            if ($castleArmyToReturnArmyToOne->getName() == 'Cavalry' && $castleArmyToReturnArmyToOne->getLevel() == 2)
                            {
                                $isFound = true;
                                $castleArmyToReturnArmyToOne->setAmount($castleArmyToReturnArmyToOne->getAmount() + $battleReport->getAttackerRemainingCavalryLvl2());
                                $this->em->persist($castleArmyToReturnArmyToOne);
                                $this->em->flush();
                            }
                        }
                        if ($isFound == false)
                        {
                            $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Cavalry', 'level' => 2));
                            $armyCreate = new Army();
                            $armyCreate->setCastleId($castleToReturnArmyTo);
                            $armyCreate->setAmount($battleReport->getAttackerRemainingCavalryLvl2());
                            $armyCreate->setName($armyStats->getName());
                            $armyCreate->setLevel($armyStats->getLevel());
                            $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                            $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                            $armyCreate->setDamage($armyStats->getDamage());
                            $armyCreate->setHealth($armyStats->getHealth());

                            if ($castleToReturnArmyTo->getName() == 'Dwarf')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Elfs')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Mages')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Ninja')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Olymp')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Vampire')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireCavalry.jpg');
                            }
                            $this->em->persist($armyCreate);
                            $this->em->flush();
                        }
                    }

                    // Level 3
                    if ($battleReport->getAttackerRemainingCavalryLvl3() > 0)
                    {
                        $isFound = false;
                        foreach ($castleArmyToReturnArmyTo as $castleArmyToReturnArmyToOne)
                        {
                            if ($castleArmyToReturnArmyToOne->getName() == 'Cavalry' && $castleArmyToReturnArmyToOne->getLevel() == 3)
                            {
                                $isFound = true;
                                $castleArmyToReturnArmyToOne->setAmount($castleArmyToReturnArmyToOne->getAmount() + $battleReport->getAttackerRemainingCavalryLvl3());
                                $this->em->persist($castleArmyToReturnArmyToOne);
                                $this->em->flush();
                            }
                        }
                        if ($isFound == false)
                        {
                            $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Cavalry', 'level' => 3));
                            $armyCreate = new Army();
                            $armyCreate->setCastleId($castleToReturnArmyTo);
                            $armyCreate->setAmount($battleReport->getAttackerRemainingCavalryLvl3());
                            $armyCreate->setName($armyStats->getName());
                            $armyCreate->setLevel($armyStats->getLevel());
                            $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                            $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                            $armyCreate->setDamage($armyStats->getDamage());
                            $armyCreate->setHealth($armyStats->getHealth());

                            if ($castleToReturnArmyTo->getName() == 'Dwarf')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Elfs')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Mages')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Ninja')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Olymp')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympCavalry.jpg');
                            }
                            elseif ($castleToReturnArmyTo->getName() == 'Vampire')
                            {
                                $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireCavalry.jpg');
                            }
                            $this->em->persist($armyCreate);
                            $this->em->flush();
                        }
                    }

                    $battleReport->setArmyReturnedToCastle(true);
                    $this->em->persist($battleReport);
                    $this->em->flush();
                }
            }
        }
    }
}