<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 27.3.2018 г.
 * Time: 12:34 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\BattlesTemp;
use AppBundle\Entity\User;
use Symfony\Component\Form\Form;

interface BattlesTempServiceInterface
{
    /**
     * @param User $user
     * @param Form $form
     * @param int $maxAmountFootmenLvl1
     * @param int $maxAmountFootmenLvl2
     * @param int $maxAmountFootmenLvl3
     * @param int $maxAmountArchersLvl1
     * @param int $maxAmountArchersLvl2
     * @param int $maxAmountArchersLvl3
     * @param int $maxAmountCavalryLvl1
     * @param int $maxAmountCavalryLvl2
     * @param int $maxAmountCavalryLvl3
     * @return mixed
     */
    public function createNewBattlesTemp(User $user, Form $form,
                                         int $maxAmountFootmenLvl1,
                                         int $maxAmountFootmenLvl2,
                                         int $maxAmountFootmenLvl3,
                                         int $maxAmountArchersLvl1,
                                         int $maxAmountArchersLvl2,
                                         int $maxAmountArchersLvl3,
                                         int $maxAmountCavalryLvl1,
                                         int $maxAmountCavalryLvl2,
                                         int $maxAmountCavalryLvl3);
}