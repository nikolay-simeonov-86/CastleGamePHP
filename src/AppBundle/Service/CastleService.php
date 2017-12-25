<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 20.12.2017 г.
 * Time: 04:00 ч.
 */

namespace AppBundle\Service;


class CastleService implements CastleServiceInterface
{

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
}