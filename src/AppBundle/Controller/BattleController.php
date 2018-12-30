<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Army;
use AppBundle\Entity\BattleReports;
use AppBundle\Entity\BattlesTemp;
use AppBundle\Entity\Castle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BattleController extends BaseController
{
    /**
     * @Route("/battles{success}", name="user_battles")
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBattlesAction(bool $success = false)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        return $this->render('view/user_battles.html.twig', array('success' => $success));
    }

    /**
     * @Route("/battles/incoming", name="user_battles_incoming")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBattlesIncomingAction()
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $incomingAttacksArray = $this->battlesService->createAllUserArmyIncomingAttacksArray($user);

        return $this->render('view/user_battles_incoming.html.twig', array('incomingAttacks' => $incomingAttacksArray));
    }

    /**
     * @Route("/battles/outgoing", name="user_battles_outgoing")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBattlesOutgoingAction()
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $outgoingAttacksArray = $this->battlesService->createAllUserArmyOutgoingAttacksArray($user);

        return $this->render('view/user_battles_outgoing.html.twig', array('outgoingAttacks' => $outgoingAttacksArray));
    }

    /**
     * @Route("/battles/send_attack_castle", name="user_battles_send_attack_castle")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBattlesSendAttackCastleAction(Request $request)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $user));
        $allArmy = [];
        foreach ($castles as $castle)
        {
            $this->castleService->updateCastle($castle->getId());
            $armyTemp = $this->em->getRepository(Army::class)->findBy(array('castleId' => $castle->getId()));

            if ($armyTemp)
            {
                foreach ($armyTemp as $army)
                {
                    $this->armyService->updateArmy($army->getId());
                    $allArmy[] = $army;
                }
            }
        }
        uasort($allArmy, function($a,$b){
            /**
             * @var Army $a
             * @var Army $b
             */
            $c = strcmp($a->getName(), $b->getName());
            $c .= $a->getLevel() - $b->getLevel();
            return $c;
        });

        return $this->render('view/user_battle_send_attack_castle.html.twig', array('castles' => $castles,
            'allArmy' => $allArmy));
    }

    /**
     * @Route("/battles/send_attack_army/{castleId}", name="user_battles_send_attack_army")
     * @param Request $request
     * @param int $castleId
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBattlesSendAttackArmyAction(Request $request, int $castleId)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $maxAmountArray = $this->armyService->maximumArmyAmountForBattle($castleId);
        list($maxAmountFootmenLvl1,
            $maxAmountFootmenLvl2,
            $maxAmountFootmenLvl3,
            $maxAmountArchersLvl1,
            $maxAmountArchersLvl2,
            $maxAmountArchersLvl3,
            $maxAmountCavalryLvl1,
            $maxAmountCavalryLvl2,
            $maxAmountCavalryLvl3) = $maxAmountArray;

        $form = $this->createFormBuilder()
            ->add('username', TextType::class, array('attr' =>
                array('class' => 'form-control text-center')))
            ->add('footmenLvl1', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountFootmenLvl1)))
            ->add('footmenLvl2', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountFootmenLvl2)))
            ->add('footmenLvl3', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountFootmenLvl3)))
            ->add('archersLvl1', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountArchersLvl1)))
            ->add('archersLvl2', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountArchersLvl2)))
            ->add('archersLvl3', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountArchersLvl3)))
            ->add('cavalryLvl1', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountCavalryLvl1)))
            ->add('cavalryLvl2', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountCavalryLvl2)))
            ->add('cavalryLvl3', IntegerType::class, array('attr' =>
                array('value' => 0,
                    'min' => 0,
                    'max' => $maxAmountCavalryLvl3)))
            ->add('Ready', SubmitType::class, array('attr' =>
                array('type' => 'button',
                    'class' => 'btn btn-lg btn-success bodytext cursor-pointer send-a-message-button')))
            ->getForm();
        $form->handleRequest($request);

        if (null == $this->em->getRepository(Castle::class)->findOneBy(array('id' => $castleId)))
        {
            return $this->redirectToRoute('user_battles_send_attack_castle');
        }
        $castle = $this->em->getRepository(Castle::class)->findOneBy(array('id' => $castleId));
        if ($castle->getUserId() != $user)
        {
            return $this->redirectToRoute('user_battles_send_attack_castle');
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            if (null == $this->em->getRepository(Castle::class)->findOneBy(array('id' => $castleId)))
            {
                return $this->redirectToRoute('user_battles_send_attack_castle');
            }
            $castle = $this->em->getRepository(Castle::class)->findOneBy(array('id' => $castleId));
            if ($castle->getUserId() != $user)
            {
                return $this->redirectToRoute('user_battles_send_attack_castle');
            }

            $message = $this->battlesTempService->createNewBattlesTemp($user, $form,
                $maxAmountFootmenLvl1,
                $maxAmountFootmenLvl2,
                $maxAmountFootmenLvl3,
                $maxAmountArchersLvl1,
                $maxAmountArchersLvl2,
                $maxAmountArchersLvl3,
                $maxAmountCavalryLvl1,
                $maxAmountCavalryLvl2,
                $maxAmountCavalryLvl3);

            if (is_string($message))
            {
                return $this->render('view/user_battle_send_attack_army.html.twig', array('form' => $form->createView(),
                    'maxAmountFootmenLvl1' => $maxAmountFootmenLvl1,
                    'maxAmountFootmenLvl2' => $maxAmountFootmenLvl2,
                    'maxAmountFootmenLvl3' => $maxAmountFootmenLvl3,
                    'maxAmountArchersLvl1' => $maxAmountArchersLvl1,
                    'maxAmountArchersLvl2' => $maxAmountArchersLvl2,
                    'maxAmountArchersLvl3' => $maxAmountArchersLvl3,
                    'maxAmountCavalryLvl1' => $maxAmountCavalryLvl1,
                    'maxAmountCavalryLvl2' => $maxAmountCavalryLvl2,
                    'maxAmountCavalryLvl3' => $maxAmountCavalryLvl3,
                    'message' => $message));
            }
            else
            {
                return $this->redirectToRoute('user_battles_send_attack_confirm', array('castleId' => $castleId, 'battleTempId' => $message));
            }
        }

        return $this->render('view/user_battle_send_attack_army.html.twig', array('form' => $form->createView(),
            'maxAmountFootmenLvl1' => $maxAmountFootmenLvl1,
            'maxAmountFootmenLvl2' => $maxAmountFootmenLvl2,
            'maxAmountFootmenLvl3' => $maxAmountFootmenLvl3,
            'maxAmountArchersLvl1' => $maxAmountArchersLvl1,
            'maxAmountArchersLvl2' => $maxAmountArchersLvl2,
            'maxAmountArchersLvl3' => $maxAmountArchersLvl3,
            'maxAmountCavalryLvl1' => $maxAmountCavalryLvl1,
            'maxAmountCavalryLvl2' => $maxAmountCavalryLvl2,
            'maxAmountCavalryLvl3' => $maxAmountCavalryLvl3));
    }

    /**
     * @Route("/battles/send_attack_confirm/{castleId}/{battleTempId}", name="user_battles_send_attack_confirm")
     * @param Request $request
     * @param int $castleId
     * @param int $battleTempId
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBattlesSendAttackConfirmAction(Request $request,int $castleId, int $battleTempId)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $form = $form = $this->createFormBuilder()
            ->add('Confirm', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        $battlesTemp = $this->em->getRepository(BattlesTemp::class)->find($battleTempId);

        if (null == $this->em->getRepository(Castle::class)->findOneBy(array('id' => $castleId)))
        {
            return $this->redirectToRoute('user_battles_send_attack_castle');
        }

        $castle = $this->em->getRepository(Castle::class)->findOneBy(array('id' => $castleId));

        if ($castle->getUserId() != $user)
        {
            return $this->redirectToRoute('user_battles_send_attack_castle');
        }

        if (null == $battlesTemp)
        {
            return $this->redirectToRoute('user_battles_send_attack_army', array('castleId' => $castleId));
        }
        if ($battlesTemp->getAttacker() != $user)
        {
            return $this->redirectToRoute('user_battles_send_attack_army', array('castleId' => $castleId));
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->battlesService->createNewBattle($castle, $battlesTemp);

            $success = true;
            return $this->redirectToRoute('user_battles', array('success' => $success));
        }

        return $this->render('view/user_battle_send_attack_confirm.html.twig', array('form' => $form->createView(),
            'battlesTemp' => $battlesTemp,
            'castleId' => $castleId));
    }

    /**
     * @Route("/battles/reports", name="user_battle_reports")
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function battleReportsAction()
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $allAttackReports = $this->em->getRepository(BattleReports::class)
            ->findBy(array('attacker' => $user->getUsername(), 'owner' => $user), array('battleDate' => 'DESC'));
        $allDefenceReports = $this->em->getRepository(BattleReports::class)
            ->findBy(array('defender' => $user->getUsername(), 'owner' => $user), array('battleDate' => 'DESC'));

        return $this->render('view/user_battle_reports.html.twig', array('allAttackReports' => $allAttackReports,
            'allDefenceReports' => $allDefenceReports));
    }

    /**
     * @Route("/battles/reports/{id}", name="user_battle_report_details")
     * @param int $id
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function battleReportDetailsAction(int $id)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $username = $user->getUsername();

        if (null == $this->em->getRepository(BattleReports::class)->findOneBy(array('id' => $id)))
        {
            return $this->redirectToRoute('user_battle_reports');
        }

        $report = $this->em->getRepository(BattleReports::class)->findOneBy(array('id' => $id));

        if ($report->getOwner() != $user)
        {
            return $this->redirectToRoute('user_battle_reports');
        }

        $report->setVisited(true);
        $this->em->persist($report);
        $this->em->flush();

        return $this->render('view/user_battle_report_details.html.twig', array('report' => $report,
            'user' => $username));
    }

    /**
     * @Route("/battles/reports/delete/{id}", name="user_battle_report_delete")
     * @param int $id
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function battleReportsDeleteAction(int $id)
    {
        $user = $this->getUser();

        if (null == $this->em->getRepository(BattleReports::class)->findOneBy(array('id' => $id)))
        {
            return $this->redirectToRoute('user_battle_reports');
        }

        $report = $this->em->getRepository(BattleReports::class)->findOneBy(array('id' => $id));

        if ($report->getOwner() != $user)
        {
            return $this->redirectToRoute('user_battle_reports');
        }

        $this->em->remove($report);
        $this->em->flush();

        return $this->redirectToRoute('user_battle_reports');
    }
}
