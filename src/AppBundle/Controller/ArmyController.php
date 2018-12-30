<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Army;
use AppBundle\Entity\ArmyTrainTimers;
use AppBundle\Entity\Castle;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArmyController extends BaseController
{
    /**
     * @Route("/army/{success}", name="user_army")
     * @param Request $request
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userArmyAction(Request $request, bool $success = false)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $userId = $this->getUser()->getId();

        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));
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
                    if ($army->getAmount() == 0)
                    {
                        $this->em->remove($army);
                        $this->em->flush();
                    }
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

        return $this->render('view/army.html.twig', array('castles' => $castles, 'allArmy' => $allArmy, 'success' => $success));
    }

    /**
     * @Route("/train_army/{id}/{army}", name="train_army")
     * @param string $army
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     * @throws \Exception
     */
    public function userTrainArmyAction(int $id, string $army, Request $request)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $castle = $this->em->getRepository(Castle::class)->find($id);
        $currentDateTime = new \DateTime("now");

        $prizes = $this->armyStatisticsService->armyCostForOneUnit($castle, $army);
        list($foodCostForOne, $metalCostForOne, $level) = $prizes;

        if ($this->em->getRepository(Army::class)->findOneBy(array('name' => $army, 'level' => $level, 'castleId' => $castle)))
        {
            $armyTemp = $this->em->getRepository(Army::class)->findOneBy(array('name' => $army, 'level' => $level, 'castleId' => $castle));
            $this->armyService->updateArmy($armyTemp->getId());

            $armyVisualizeTemp = $this->em->getRepository(ArmyTrainTimers::class)->findBy(array('armyId' => $armyTemp, 'armyType' => $army));
            $armyVisualize = [];
            $counter = 0;
            foreach ($armyVisualizeTemp as $armyVisualizeOne)
            {
                $tempInterval = date_diff($armyVisualizeOne->getFinishTime(), $currentDateTime);
                $interval = $tempInterval->format('%D days %H hours and %I minutes');
                $armyVisualizeTemp1[] = $armyVisualizeOne;
                $temp['armyType'] = $armyVisualizeOne->getArmyType();
                $temp['trainAmount'] = $armyVisualizeOne->getTrainAmount();
                $temp['timeRemaining'] = $interval;
                $armyVisualize[] = $temp;
                $counter++;
            }
        }
        else
        {
            $armyVisualize = [];
            $counter = 0;
        }

        $userFood = $this->getUser()->getFood();
        $userMetal = $this->getUser()->getMetal();

        $maxAmount = $this->armyService->maximumArmyAmountToTrain($userFood, $userMetal, $army, $level);

        $form = $this->createFormBuilder()->add('Amount', IntegerType::class, array('attr' =>
            array('value' => 1,
                'min' => 1,
                'max' => $maxAmount)))
            ->add('Train', SubmitType::class)->getForm();
        $form->handleRequest($request);

        try
        {
            if ($counter >= 5)
            {
                throw $exception = new Exception('You can only train 5 groups at once');
            }
        }
        catch (\Exception $exception)
        {
            $message = $exception->getMessage();
            return $this->render('view/train_army.html.twig', array('form' => $form->createView(),
                'army' => $army,
                'maxAmount' => $maxAmount,
                'armyVisualize' => $armyVisualize,
                'foodCostForOne' => $foodCostForOne,
                'metalCostForOne' => $metalCostForOne,
                'message' => $message));
        }
        if ($form->isSubmitted() && $form->isValid())
        {
            try
            {
                if ($form->get('Amount')->getData() > $maxAmount)
                {
                    throw $exception = new Exception('Not enough resources to train this many units');
                }
                if ($form->get('Amount')->getData() == 0)
                {
                    throw $exception = new Exception('Invalid input');
                }
            }
            catch (\Exception $exception)
            {
                $message = $exception->getMessage();
                return $this->render('view/train_army.html.twig', array('form' => $form->createView(),
                    'army' => $army,
                    'maxAmount' => $maxAmount,
                    'foodCostForOne' => $foodCostForOne,
                    'metalCostForOne' => $metalCostForOne,
                    'message' => $message));
            }
            return $this->redirectToRoute('confirm_train_army', array('army' => $army,
                'id' => $id,
                'amount' => $form->get('Amount')->getData()));
        }

        return $this->render('view/train_army.html.twig', array('form' => $form->createView(),
            'army' => $army,
            'maxAmount' => $maxAmount,
            'foodCostForOne' => $foodCostForOne,
            'metalCostForOne' => $metalCostForOne,
            'armyVisualize' => $armyVisualize));
    }

    /**
     * @Route("/confirm_train_army/{id}/{army}/{amount}", name="confirm_train_army")
     * @param int $id
     * @param string $army
     * @param int $amount
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userConfirmTrainArmyAction(int $id, string $army, int $amount, Request $request)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $form = $this->createFormBuilder()->add('Confirm', SubmitType::class)->getForm();
        $form->handleRequest($request);

        $castle = $this->em->getRepository(Castle::class)->find($id);

        if ($army == 'Footmen')
        {
            $level = $castle->getArmyLvl1Building();
        }
        elseif ($army == 'Archers')
        {
            $level = $castle->getArmyLvl2Building();
        }
        elseif ($army == 'Cavalry')
        {
            $level = $castle->getArmyLvl3Building();
        }

        $result = $this->armyStatisticsService->armyCostAndTimeToTrain($army, $level, $amount);
        list($prizeFood, $prizeMetal, $trainTime) = $result;

        if ($this->em->getRepository(Army::class)->findOneBy(array('name' => $army, 'level' => $level, 'castleId' => $castle)))
        {
            $armyTemp = $this->em->getRepository(Army::class)->findOneBy(array('name' => $army, 'level' => $level, 'castleId' => $castle));
            $this->armyService->updateArmy($armyTemp->getId());

            $counter = count($this->em->getRepository(ArmyTrainTimers::class)->findBy(array('armyId' => $armyTemp, 'armyType' => $army)));
        }
        else
        {
            $counter = 0;
        }

        try
        {
            if ($counter >= 5)
            {
                throw $exception = new Exception('You can only train 5 groups at once');
            }
        }
        catch (\Exception $exception)
        {
            $message = $exception->getMessage();
            return $this->render('view/confirm_train_army.html.twig', array('form' => $form->createView(),
                'amount' => $amount,
                'army' => $army,
                'prizeFood' => $prizeFood,
                'prizeMetal' => $prizeMetal,
                'trainTime' => $trainTime,
                'id' => $id,
                'message' => $message));
        }
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->armyTrainTimersService->createArmyTrainTimer($army, $castle, $amount, $id);

            $user = $this->getUser();
            $message = $this->armyService->trainArmyUserPayment($user, $prizeFood, $prizeMetal);

            if ($message)
            {
                return $this->render('view/confirm_train_army.html.twig', array('form' => $form->createView(),
                    'amount' => $amount,
                    'army' => $army,
                    'prizeFood' => $prizeFood,
                    'prizeMetal' => $prizeMetal,
                    'trainTime' => $trainTime,
                    'id' => $id,
                    'message' => $message));
            }
            $success = true;
            return $this->redirectToRoute('user_army', array('success' => $success));
        }
        return $this->render('view/confirm_train_army.html.twig', array('form' => $form->createView(),
            'amount' => $amount,
            'army' => $army,
            'prizeFood' => $prizeFood,
            'prizeMetal' => $prizeMetal,
            'trainTime' => $trainTime,
            'id' => $id));
    }
}
