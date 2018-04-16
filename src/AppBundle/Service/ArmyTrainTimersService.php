<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 29.1.2018 г.
 * Time: 09:44 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\Army;
use AppBundle\Entity\ArmyStatistics;
use AppBundle\Entity\ArmyTrainTimers;
use AppBundle\Entity\Castle;
use AppBundle\Repository\ArmyTrainTimersRepository;
use Doctrine\ORM\EntityManagerInterface;

class ArmyTrainTimersService implements ArmyTrainTimersServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ArmyTrainTimersRepository
     */
    private $armyTrainTimersRepository;

    /**
     * ArmyTrainTimersService constructor.
     * @param ArmyTrainTimersRepository $armyTrainTimersRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(ArmyTrainTimersRepository $armyTrainTimersRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->armyTrainTimersRepository = $armyTrainTimersRepository;
    }

    /**
     * @param string $army
     * @param Castle $castle
     * @param int $amount
     * @param int $id
     * @return null
     */
    public function createArmyTrainTimer(string $army, Castle $castle, int $amount, int $id)
    {
        if ($army == 'Footmen')
        {
            if ($castle->getArmyLvl1Building() == 1)
            {
                $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Footmen', 'level' => 1));

                if ($this->em->getRepository(Army::class)->findOneBy(array('name' => 'Footmen', 'level' => 1, 'castleId' => $id)))
                {
                    $armyCreate = $this->em->getRepository(Army::class)->findOneBy(array('name' => 'Footmen', 'level' => 1, 'castleId' => $id));
                }
                else
                {
                    $armyCreate = new Army();
                    $armyCreate->setCastleId($castle);
                    $armyCreate->setAmount(0);
                    $armyCreate->setName($armyStats->getName());
                    $armyCreate->setLevel($armyStats->getLevel());
                    $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                    $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                    $armyCreate->setDamage($armyStats->getDamage());
                    $armyCreate->setHealth($armyStats->getHealth());

                    if ($castle->getName() == 'Dwarf')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Elfs')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Mages')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Ninja')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Olymp')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Vampire')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireFootmen.jpg');
                    }
                    $this->em->persist($armyCreate);
                }

                $createTempArmy = new ArmyTrainTimers();
                $createTempArmy->setCastleId($armyCreate);
                $createTempArmy->setArmyType($army);
                $createTempArmy->setTrainAmount($amount);
                $startDate = new \DateTime;
                $minutes = $amount*$armyStats->getTrainTime();
                try {
                    $createTempArmy->setFinishTime($startDate->add(new \DateInterval('PT' . $minutes . 'M')));
                } catch (\Exception $exception) {
                }
            }
            elseif ($castle->getArmyLvl1Building() == 2)
            {
                $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Footmen', 'level' => 2));

                if ($this->em->getRepository(Army::class)->findOneBy(array('name' => 'Footmen', 'level' => 2, 'castleId' => $id)))
                {
                    $armyCreate = $this->em->getRepository(Army::class)->findOneBy(array('name' => 'Footmen', 'level' => 2, 'castleId' => $id));
                }
                else
                {
                    $armyCreate = new Army();
                    $armyCreate->setCastleId($castle);
                    $armyCreate->setAmount(0);
                    $armyCreate->setName($armyStats->getName());
                    $armyCreate->setLevel($armyStats->getLevel());
                    $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                    $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                    $armyCreate->setDamage($armyStats->getDamage());
                    $armyCreate->setHealth($armyStats->getHealth());

                    if ($castle->getName() == 'Dwarf')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Elfs')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Mages')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Ninja')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Olymp')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Vampire')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireFootmen.jpg');
                    }
                    $this->em->persist($armyCreate);
                }

                $createTempArmy = new ArmyTrainTimers();
                $createTempArmy->setCastleId($armyCreate);
                $createTempArmy->setArmyType($army);
                $createTempArmy->setTrainAmount($amount);
                $startDate = new \DateTime;
                $minutes = $amount*$armyStats->getTrainTime();
                try {
                    $createTempArmy->setFinishTime($startDate->add(new \DateInterval('PT' . $minutes . 'M')));
                } catch (\Exception $exception) {
                }
            }
            elseif ($castle->getArmyLvl1Building() == 3)
            {
                $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Footmen', 'level' => 3));

                if ($this->em->getRepository(Army::class)->findOneBy(array('name' => 'Footmen', 'level' => 3, 'castleId' => $id)))
                {
                    $armyCreate = $this->em->getRepository(Army::class)->findOneBy(array('name' => 'Footmen', 'level' => 3, 'castleId' => $id));
                }
                else
                {
                    $armyCreate = new Army();
                    $armyCreate->setCastleId($castle);
                    $armyCreate->setAmount(0);
                    $armyCreate->setName($armyStats->getName());
                    $armyCreate->setLevel($armyStats->getLevel());
                    $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                    $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                    $armyCreate->setDamage($armyStats->getDamage());
                    $armyCreate->setHealth($armyStats->getHealth());

                    if ($castle->getName() == 'Dwarf')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Elfs')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Mages')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Ninja')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Olymp')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympFootmen.jpg');
                    }
                    elseif ($castle->getName() == 'Vampire')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireFootmen.jpg');
                    }
                    $this->em->persist($armyCreate);
                }

                $createTempArmy = new ArmyTrainTimers();
                $createTempArmy->setCastleId($armyCreate);
                $createTempArmy->setArmyType($army);
                $createTempArmy->setTrainAmount($amount);
                $startDate = new \DateTime;
                $minutes = $amount*$armyStats->getTrainTime();
                try {
                    $createTempArmy->setFinishTime($startDate->add(new \DateInterval('PT' . $minutes . 'M')));
                } catch (\Exception $exception) {
                    $message = $exception->getMessage();
                    return $message;
                }
            }
        }
        if ($army == 'Archers')
        {
            if ($castle->getArmyLvl2Building() == 1)
            {
                $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Archers', 'level' => 1));

                if ($this->em->getRepository(Army::class)->findOneBy(array('name' => 'Archers', 'level' => 1, 'castleId' => $id)))
                {
                    $armyCreate = $this->em->getRepository(Army::class)->findOneBy(array('name' => 'Archers', 'level' => 1, 'castleId' => $id));
                }
                else
                {
                    $armyCreate = new Army();
                    $armyCreate->setCastleId($castle);
                    $armyCreate->setAmount(0);
                    $armyCreate->setName($armyStats->getName());
                    $armyCreate->setLevel($armyStats->getLevel());
                    $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                    $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                    $armyCreate->setDamage($armyStats->getDamage());
                    $armyCreate->setHealth($armyStats->getHealth());

                    if ($castle->getName() == 'Dwarf')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Elfs')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Mages')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Ninja')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Olymp')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Vampire')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireArchers.jpg');
                    }
                    $this->em->persist($armyCreate);
                }

                $createTempArmy = new ArmyTrainTimers();
                $createTempArmy->setCastleId($armyCreate);
                $createTempArmy->setArmyType($army);
                $createTempArmy->setTrainAmount($amount);
                $startDate = new \DateTime;
                $minutes = $amount*$armyStats->getTrainTime();
                try {
                    $createTempArmy->setFinishTime($startDate->add(new \DateInterval('PT' . $minutes . 'M')));
                } catch (\Exception $exception) {
                }
            }
            elseif ($castle->getArmyLvl2Building() == 2)
            {
                $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Archers', 'level' => 2));

                if ($this->em->getRepository(Army::class)->findOneBy(array('name' => 'Archers', 'level' => 2, 'castleId' => $id)))
                {
                    $armyCreate = $this->em->getRepository(Army::class)->findOneBy(array('name' => 'Archers', 'level' => 2, 'castleId' => $id));
                }
                else
                {
                    $armyCreate = new Army();
                    $armyCreate->setCastleId($castle);
                    $armyCreate->setAmount(0);
                    $armyCreate->setName($armyStats->getName());
                    $armyCreate->setLevel($armyStats->getLevel());
                    $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                    $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                    $armyCreate->setDamage($armyStats->getDamage());
                    $armyCreate->setHealth($armyStats->getHealth());

                    if ($castle->getName() == 'Dwarf')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Elfs')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Mages')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Ninja')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Olymp')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Vampire')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireArchers.jpg');
                    }
                    $this->em->persist($armyCreate);
                }

                $createTempArmy = new ArmyTrainTimers();
                $createTempArmy->setCastleId($armyCreate);
                $createTempArmy->setArmyType($army);
                $createTempArmy->setTrainAmount($amount);
                $startDate = new \DateTime;
                $minutes = $amount*$armyStats->getTrainTime();
                try {
                    $createTempArmy->setFinishTime($startDate->add(new \DateInterval('PT' . $minutes . 'M')));
                } catch (\Exception $exception) {
                }
            }
            elseif ($castle->getArmyLvl2Building() == 3)
            {
                $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Archers', 'level' => 3));

                if ($this->em->getRepository(Army::class)->findOneBy(array('name' => 'Archers', 'level' => 3, 'castleId' => $id)))
                {
                    $armyCreate = $this->em->getRepository(Army::class)->findOneBy(array('name' => 'Archers', 'level' => 3, 'castleId' => $id));
                }
                else
                {
                    $armyCreate = new Army();
                    $armyCreate->setCastleId($castle);
                    $armyCreate->setAmount(0);
                    $armyCreate->setName($armyStats->getName());
                    $armyCreate->setLevel($armyStats->getLevel());
                    $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                    $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                    $armyCreate->setDamage($armyStats->getDamage());
                    $armyCreate->setHealth($armyStats->getHealth());

                    if ($castle->getName() == 'Dwarf')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Elfs')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Mages')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Ninja')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Olymp')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympArchers.jpg');
                    }
                    elseif ($castle->getName() == 'Vampire')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireArchers.jpg');
                    }
                    $this->em->persist($armyCreate);
                }

                $createTempArmy = new ArmyTrainTimers();
                $createTempArmy->setCastleId($armyCreate);
                $createTempArmy->setArmyType($army);
                $createTempArmy->setTrainAmount($amount);
                $startDate = new \DateTime;
                $minutes = $amount*$armyStats->getTrainTime();
                try {
                    $createTempArmy->setFinishTime($startDate->add(new \DateInterval('PT' . $minutes . 'M')));
                } catch (\Exception $exception) {
                }
            }
        }
        if ($army == 'Cavalry')
        {
            if ($castle->getArmyLvl3Building() == 1)
            {
                $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Cavalry', 'level' => 1));

                if ($this->em->getRepository(Army::class)->findOneBy(array('name' => 'Cavalry', 'level' => 1, 'castleId' => $id)))
                {
                    $armyCreate = $this->em->getRepository(Army::class)->findOneBy(array('name' => 'Cavalry', 'level' => 1, 'castleId' => $id));
                }
                else
                {
                    $armyCreate = new Army();
                    $armyCreate->setCastleId($castle);
                    $armyCreate->setAmount(0);
                    $armyCreate->setName($armyStats->getName());
                    $armyCreate->setLevel($armyStats->getLevel());
                    $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                    $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                    $armyCreate->setDamage($armyStats->getDamage());
                    $armyCreate->setHealth($armyStats->getHealth());

                    if ($castle->getName() == 'Dwarf')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Elfs')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Mages')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Ninja')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Olymp')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Vampire')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireCavalry.jpg');
                    }
                    $this->em->persist($armyCreate);
                }

                $createTempArmy = new ArmyTrainTimers();
                $createTempArmy->setCastleId($armyCreate);
                $createTempArmy->setArmyType($army);
                $createTempArmy->setTrainAmount($amount);
                $startDate = new \DateTime;
                $minutes = $amount*$armyStats->getTrainTime();
                try {
                    $createTempArmy->setFinishTime($startDate->add(new \DateInterval('PT' . $minutes . 'M')));
                } catch (\Exception $exception) {
                }
            }
            elseif ($castle->getArmyLvl3Building() == 2)
            {
                $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Cavalry', 'level' => 2));

                if ($this->em->getRepository(Army::class)->findOneBy(array('name' => 'Cavalry', 'level' => 2, 'castleId' => $id)))
                {
                    $armyCreate = $this->em->getRepository(Army::class)->findOneBy(array('name' => 'Cavalry', 'level' => 2, 'castleId' => $id));
                }
                else
                {
                    $armyCreate = new Army();
                    $armyCreate->setCastleId($castle);
                    $armyCreate->setAmount(0);
                    $armyCreate->setName($armyStats->getName());
                    $armyCreate->setLevel($armyStats->getLevel());
                    $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                    $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                    $armyCreate->setDamage($armyStats->getDamage());
                    $armyCreate->setHealth($armyStats->getHealth());

                    if ($castle->getName() == 'Dwarf')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Elfs')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Mages')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Ninja')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Olymp')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Vampire')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireCavalry.jpg');
                    }
                    $this->em->persist($armyCreate);
                }

                $createTempArmy = new ArmyTrainTimers();
                $createTempArmy->setCastleId($armyCreate);
                $createTempArmy->setArmyType($army);
                $createTempArmy->setTrainAmount($amount);
                $startDate = new \DateTime;
                $minutes = $amount*$armyStats->getTrainTime();
                try {
                    $createTempArmy->setFinishTime($startDate->add(new \DateInterval('PT' . $minutes . 'M')));
                } catch (\Exception $exception) {
                }
            }
            elseif ($castle->getArmyLvl3Building() == 3)
            {
                $armyStats = $this->em->getRepository(ArmyStatistics::class)->findOneBy(array('name' => 'Cavalry', 'level' => 3));

                if ($this->em->getRepository(Army::class)->findOneBy(array('name' => 'Cavalry', 'level' => 3, 'castleId' => $id)))
                {
                    $armyCreate = $this->em->getRepository(Army::class)->findOneBy(array('name' => 'Cavalry', 'level' => 3, 'castleId' => $id));
                }
                else
                {
                    $armyCreate = new Army();
                    $armyCreate->setCastleId($castle);
                    $armyCreate->setAmount(0);
                    $armyCreate->setName($armyStats->getName());
                    $armyCreate->setLevel($armyStats->getLevel());
                    $armyCreate->setBonusDamage($armyStats->getBonusDamage());
                    $armyCreate->setBonusVersus($armyStats->getBonusVersus());
                    $armyCreate->setDamage($armyStats->getDamage());
                    $armyCreate->setHealth($armyStats->getHealth());

                    if ($castle->getName() == 'Dwarf')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/DwarfCastle/DwarfCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Elfs')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/ElfsCastle/ElfsCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Mages')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/MageCastle/MageCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Ninja')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/NinjaCastle/NinjaCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Olymp')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/OlympCastle/OlympCavalry.jpg');
                    }
                    elseif ($castle->getName() == 'Vampire')
                    {
                        $armyCreate->setArmyPicture('/pictures/Units/VampireCastle/VampireCavalry.jpg');
                    }
                    $this->em->persist($armyCreate);
                }

                $createTempArmy = new ArmyTrainTimers();
                $createTempArmy->setCastleId($armyCreate);
                $createTempArmy->setArmyType($army);
                $createTempArmy->setTrainAmount($amount);
                $startDate = new \DateTime;
                $minutes = $amount*$armyStats->getTrainTime();
                try {
                    $createTempArmy->setFinishTime($startDate->add(new \DateInterval('PT' . $minutes . 'M')));
                } catch (\Exception $exception) {
                }
            }
        }
        $this->em->persist($createTempArmy);
        $this->em->flush();
        return null;
    }
}