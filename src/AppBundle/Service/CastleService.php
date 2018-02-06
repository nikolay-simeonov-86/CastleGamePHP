<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 20.12.2017 г.
 * Time: 04:00 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\BuildingUpdateProperties;
use AppBundle\Entity\BuildingUpdateTimers;
use AppBundle\Entity\Castle;
use AppBundle\Entity\User;
use AppBundle\Repository\CastleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\User\UserInterface;

class CastleService implements CastleServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var CastleRepository
     */
    private $castleRepository;

    /**
     * CastleService constructor.
     * @param CastleRepository $castleRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(CastleRepository $castleRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->castleRepository = $castleRepository;
    }

    public function getArmyCount()
    {
        /**
         * Get user.id
         * SELECT castle.id, army_lvl1_count, army_lvl2_count, army_lvl3_count WHERE user.id
         * Display in Table in user.html.twig
         * Clickable Castles
         * Reform table with selected castle by castle.id
         */
    }

    public function getBuildingLevels()
    {
        /**
         * Get user.id
         * SELECT castle.id, army_lvl1_building, army_lvl2_building, army_lvl3_building, castle_lvl, mine_food_lvl, mine_metal_lvl WHERE user.id
         * Display in Table in user.html.twig
         * Clickable Castles
         * Reform table with selected castle by castle.id
         */
    }

    public function purchaseArmy()
    {
        /**
         * Get amount from a form
         * Select army type
         * Make variables for price of every type of army
         * Get user.id
         * Get user.incomeAll
         * SELECT castle.id, army_lvl1_count, army_lvl2_count, army_lvl3_count, army_lvl1_building, army_lvl2_building, army_lvl3_building WHERE user.id
         * if (selected building is max lvl)
         * Give a message that building is max lvl
         * if (amount*price < incomeAll)
         * Render a button accept or cancel on the same view
         * else display a message with incomeAll-amount+price
         * If accept calculate incomeAll-amount+price and update user.incomeAll
         * Then update selected army with initial amount + amount
         * If building lvl2 amount selected *2 or if lvl3 amount selected *5
         * Render updated view with success message
         */
    }

    /**
     * @param string $building
     * @param User $user
     * @param Castle $castle
     * @param BuildingUpdateProperties $buildingUpdate
     * @return null|string
     */
    public function purchaseBuilding(string $building, User $user, Castle $castle, BuildingUpdateProperties $buildingUpdate)
    {
        if ($building === 'Castle')
        {
            $level = $castle->getCastleLvl();
        }
        elseif ($building === 'Farm')
        {
            $level = $castle->getMineFoodLvl();
        }
        elseif ($building === 'Metal Mine')
        {
            $level = $castle->getMineMetalLvl();
        }
        elseif ($building === 'Footmen')
        {
            $level = $castle->getArmyLvl1Building();
        }
        elseif ($building === 'Archers')
        {
            $level = $castle->getArmyLvl2Building();
        }
        elseif ($building === 'Cavalry')
        {
            $level = $castle->getArmyLvl3Building();
        }

        if ($level === 0)
        {
            $foodCost = $buildingUpdate->getLevel1Food();
            $metalCost = $buildingUpdate->getLevel1Metal();
            $upgradeTimer = $buildingUpdate->getLevel1Timer();
        }
        elseif ($level === 1)
        {
            $foodCost = $buildingUpdate->getLevel2Food();
            $metalCost = $buildingUpdate->getLevel2Metal();
            $upgradeTimer = $buildingUpdate->getLevel2Timer();
        }
        elseif ($level === 2)
        {
            $foodCost = $buildingUpdate->getLevel3Food();
            $metalCost = $buildingUpdate->getLevel3Metal();
            $upgradeTimer = $buildingUpdate->getLevel3Timer();
        }

        $food = $user->getFood();
        $metal = $user->getMetal();

        try
        {
            if ($building === 'Castle')
            {
                if ($level === 1)
                {
                    if ($castle->getArmyLvl1Building() === 0)
                    {
                        throw $exception = new Exception('You need to build Footmen first');
                    }
                }
                elseif ($level === 2)
                {
                    if ($castle->getArmyLvl1Building() === 0)
                    {
                        throw $exception = new Exception('You need to build Footmen first');
                    }
                    if ($castle->getArmyLvl2Building() === 0)
                    {
                        throw $exception = new Exception('You need to build Archers first');
                    }
                }
            }
            elseif ($building === 'Farm')
            {
                if ($level === 1)
                {
                    if ($castle->getCastleLvl() === 0)
                    {
                        throw $exception = new Exception('You need to build Castle first');
                    }
                }
                elseif ($level === 2)
                {
                    if ($castle->getCastleLvl() === 1)
                    {
                        throw $exception = new Exception('You need to build Castle level 2 first');
                    }
                }
            }
            elseif ($building === 'Metal Mine')
            {
                if ($level === 1)
                {
                    if ($castle->getCastleLvl() === 0)
                    {
                        throw $exception = new Exception('You need to build Castle first');
                    }
                }
                elseif ($level === 2)
                {
                    if ($castle->getCastleLvl() === 1)
                    {
                        throw $exception = new Exception('You need to build Castle level 2 first');
                    }
                }
            }
            elseif ($building === 'Footmen')
            {
                if ($level === 0)
                {
                    if ($castle->getCastleLvl() === 0)
                    {
                        throw $exception = new Exception('You need to build Castle first');
                    }
                }
                elseif ($level === 1)
                {
                    if ($castle->getCastleLvl() === 1)
                    {
                        throw $exception = new Exception('You need to build Castle level 2 first');
                    }
                }
                elseif ($level === 2)
                {
                    if ($castle->getCastleLvl() === 2)
                    {
                        throw $exception = new Exception('You need to build Castle level 3 first');
                    }
                }
            }
            elseif ($building === 'Archers')
            {
                if ($level === 0)
                {
                    if ($castle->getCastleLvl() === 0)
                    {
                        throw $exception = new Exception('You need to build Castle first');
                    }
                }
                elseif ($level === 1)
                {
                    if ($castle->getCastleLvl() === 1)
                    {
                        throw $exception = new Exception('You need to build Castle level 2 first');
                    }
                }
                elseif ($level === 2)
                {
                    if ($castle->getCastleLvl() === 2)
                    {
                        throw $exception = new Exception('You need to build Castle level 3 first');
                    }
                }
            }
            elseif ($building === 'Cavalry')
            {
                if ($level === 0)
                {
                    if ($castle->getCastleLvl() === 0)
                    {
                        throw $exception = new Exception('You need to build Castle first');
                    }
                }
                elseif ($level === 1)
                {
                    if ($castle->getCastleLvl() === 1)
                    {
                        throw $exception = new Exception('You need to build Castle level 2 first');
                    }
                }
                elseif ($level === 2)
                {
                    if ($castle->getCastleLvl() === 2)
                    {
                        throw $exception = new Exception('You need to build Castle level 3 first');
                    }
                }
            }

            $foodafter = $food - $foodCost;
            $metalafter = $metal - $metalCost;

            if ($foodafter < 0 && $metalafter < 0)
            {
                $foodMessage = abs($foodafter);
                $metalMessage = abs($metalafter);
                throw $exception = new Exception("Not enough resources to upgrade. You need $foodMessage more food and $metalMessage more metal.");
            }
            if ($foodafter < 0)
            {
                $foodMessage = abs($foodafter);
                throw $exception = new Exception("Not enough food to upgrade. You need $foodMessage more food.");
            }
            if ($metalafter < 0)
            {
                $metalMessage = abs($metalafter);
                throw $exception = new Exception("Not enough metal to upgrade. You need $metalMessage more metal.");
            }

            $finishDate = new BuildingUpdateTimers();
            $finishDate->setCastleId($castle);
            $finishDate->setBuilding($building);
            $startDate = new \DateTime;
            $finishDate->setFinishTime($startDate->add(new \DateInterval("PT" . $upgradeTimer . "M")));
            $finishDate->setUpgradeToLvl($level+1);

            $user->setFood($foodafter);
            $user->setMetal($metalafter);

            $this->em->persist($finishDate);
            $this->em->persist($user);
            $this->em->flush();
        }
        catch (Exception $exception)
        {
            return $message = $exception->getMessage();
        }
        catch (\Exception $e)
        {
            return $message = $e->getMessage();
        }

        return null;
    }

    public function buildNewCastle(User $user, string $name)
    {
        $castle = new Castle();
        $castle->setName($name);
        $castle->setUserId($user);
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
     * @param int $id
     * @return Castle|null|object
     */
    public function castleInformation(int $id)
    {
        return $castle = $this->em->getRepository(Castle::class)->find($id);
    }

    /**
     * @param int $id
     * @return null
     */
    public function updateCastle(int $id)
    {
        $updates = $this->em->getRepository(BuildingUpdateTimers::class)->findBy(array('castleId' => $id));
        $castle = $this->castleRepository->find($id);
        $currentDatetime = new \DateTime("now");

        if ($updates)
        {
            foreach ($updates as $update)
            {
                if (null != $update->getFinishTime())
                {
                    if ($update->getFinishTime() < $currentDatetime)
                    {
                        if ($update->getBuilding() == 'Castle') {
                            $castle->setCastleLvl($update->getUpgradeToLvl());
                        }
                        if ($update->getBuilding() == 'Farm') {
                            $castle->setMineFoodLvl($update->getUpgradeToLvl());
                        }
                        if ($update->getBuilding() == 'Metal Mine') {
                            $castle->setMineMetalLvl($update->getUpgradeToLvl());
                        }
                        if ($update->getBuilding() == 'Footmen') {
                            $castle->setArmyLvl1Building($update->getUpgradeToLvl());
                        }
                        if ($update->getBuilding() == 'Archers') {
                            $castle->setArmyLvl2Building($update->getUpgradeToLvl());
                        }
                        if ($update->getBuilding() == 'Cavalry') {
                            $castle->setArmyLvl3Building($update->getUpgradeToLvl());
                        }
                        $this->em->remove($update);
                        $this->em->flush();
                    }
                }
            }
        }
        return null;
    }
}