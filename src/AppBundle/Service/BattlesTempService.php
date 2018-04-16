<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 27.3.2018 г.
 * Time: 12:36 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\BattlesTemp;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Form;

class BattlesTempService implements BattlesTempServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * BattlesTempService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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
     * @return null|string
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
                                         int $maxAmountCavalryLvl3)
    {
        try
        {
            if (null == $this->em->getRepository(User::class)->findOneBy(array('username' => $form->get('username')->getData())))
            {
                throw $exception = new Exception('Invalid username');
            }
            if ($form->get('footmenLvl1')->getData() > $maxAmountFootmenLvl1 || $form->get('footmenLvl1')->getData() < 0)
            {
                throw $exception = new Exception('Invalid Footmen lvl1 amount');
            }
            if ($form->get('footmenLvl2')->getData() > $maxAmountFootmenLvl2 || $form->get('footmenLvl2')->getData() < 0)
            {
                throw $exception = new Exception('Invalid Footmen lvl2 amount');
            }
            if ($form->get('footmenLvl3')->getData() > $maxAmountFootmenLvl3 || $form->get('footmenLvl3')->getData() < 0)
            {
                throw $exception = new Exception('Invalid Footmen lvl3 amount');
            }
            if ($form->get('archersLvl1')->getData() > $maxAmountArchersLvl1 || $form->get('archersLvl1')->getData() < 0)
            {
                throw $exception = new Exception('Invalid Archers lvl1 amount');
            }
            if ($form->get('archersLvl2')->getData() > $maxAmountArchersLvl2 || $form->get('archersLvl2')->getData() < 0)
            {
                throw $exception = new Exception('Invalid Archers lvl2 amount');
            }
            if ($form->get('archersLvl3')->getData() > $maxAmountArchersLvl3 || $form->get('archersLvl3')->getData() < 0)
            {
                throw $exception = new Exception('Invalid Archers lvl3 amount');
            }
            if ($form->get('cavalryLvl1')->getData() > $maxAmountCavalryLvl1 || $form->get('cavalryLvl1')->getData() < 0)
            {
                throw $exception = new Exception('Invalid Cavalry lvl1 amount');
            }
            if ($form->get('cavalryLvl2')->getData() > $maxAmountCavalryLvl2 || $form->get('cavalryLvl2')->getData() < 0)
            {
                throw $exception = new Exception('Invalid Cavalry lvl2 amount');
            }
            if ($form->get('cavalryLvl3')->getData() > $maxAmountCavalryLvl3 || $form->get('cavalryLvl3')->getData() < 0)
            {
                throw $exception = new Exception('Invalid Cavalry lvl3 amount');
            }
            if ($form->get('footmenLvl1')->getData() === 0 &&
                $form->get('footmenLvl2')->getData() === 0 &&
                $form->get('footmenLvl3')->getData() === 0 &&
                $form->get('archersLvl1')->getData() === 0 &&
                $form->get('archersLvl2')->getData() === 0 &&
                $form->get('archersLvl3')->getData() === 0 &&
                $form->get('cavalryLvl1')->getData() === 0 &&
                $form->get('cavalryLvl2')->getData() === 0 &&
                $form->get('cavalryLvl3')->getData() === 0)
            {
                throw $exception = new Exception('You must send at least ONE unit to battle');
            }

            $defender = $this->em->getRepository(User::class)->findOneBy(array('username' => $form->get('username')->getData()));
            $defenderCoordinates = $defender->getCoordinates();
            $defenderCoordinatesX = (int)($defenderCoordinates/10);
            $defenderCoordinatesY = $defenderCoordinates%10;
            $attackerCoordinates = $user->getCoordinates();
            $attackerCoordinatesX = (int)($attackerCoordinates/10);
            $attackerCoordinatesY = (int)($attackerCoordinates%10);

            $x = abs($defenderCoordinatesX-$attackerCoordinatesX);
            $y = abs($defenderCoordinatesY-$attackerCoordinatesY);
            $reachTime = max($x, $y);

            $battlesTemp = new BattlesTemp();
            $battlesTemp->setAttacker($user);
            $battlesTemp->setDefender($form->get('username')->getData());
            $battlesTemp->setFootmenLvl1($form->get('footmenLvl1')->getData());
            $battlesTemp->setFootmenLvl2($form->get('footmenLvl2')->getData());
            $battlesTemp->setFootmenLvl3($form->get('footmenLvl3')->getData());
            $battlesTemp->setArchersLvl1($form->get('archersLvl1')->getData());
            $battlesTemp->setArchersLvl2($form->get('archersLvl2')->getData());
            $battlesTemp->setArchersLvl3($form->get('archersLvl3')->getData());
            $battlesTemp->setCavalryLvl1($form->get('cavalryLvl1')->getData());
            $battlesTemp->setCavalryLvl2($form->get('cavalryLvl2')->getData());
            $battlesTemp->setCavalryLvl3($form->get('cavalryLvl3')->getData());
            $battlesTemp->setReachTime($reachTime);
            $this->em->persist($battlesTemp);
            $this->em->flush();

            return $battlesTemp->getId();
        }
        catch (\Exception $exception)
        {
            return $message = $exception->getMessage();
        }
    }
}