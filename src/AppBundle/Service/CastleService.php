<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 20.12.2017 г.
 * Time: 04:00 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\BuildingUpdateTimers;
use AppBundle\Entity\Castle;
use AppBundle\Repository\CastleRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * UserService constructor.
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

    public function purchaseBuilding()
    {
        /**
         * Get a sellect from a form of the building from the single castle view
         * Make variables for price of upgrade
         * if (selected building is max lvl)
         * Give a message that building is max lvl
         * if (selected->price < incomeAll)
         * Render a button accept or cancel on the same view
         * else display a message with incomeAll-amount+price
         * If accept calculate incomeAll-selected->price and update user.incomeAll
         * Then update column from 1 to 2 if update from lvl1 to lvl2 and from 2 to 3 if lvl2 to lvl3
         * Render updated view with success message
         */
    }

    public function buildCastle($name)
    {

    }

    public function castleInformation(int $id)
    {
        return $castle = $this->em->getRepository(Castle::class)->find($id);
    }

    /**
     * @param int $id
     */
    public function updateCastle(int $id)
    {
        $updates = $this->em->getRepository(BuildingUpdateTimers::class)->findBy(array('castleId' => $id));
        $castle = $this->em->getRepository(Castle::class)->find($id);

        if ($updates)
        {
            foreach ($updates as $update)
            {
                $currentDatetime = new \DateTime("now");
                if (null != $update->getFinishTime())
                {

                    if ($update->getFinishTime() < $currentDatetime)
                    {
    //                    dump($updates->getFinishTime());
    //                    dump($currentDatetime);
    //                    dump('Hello');
    //                    die();
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
    }
}