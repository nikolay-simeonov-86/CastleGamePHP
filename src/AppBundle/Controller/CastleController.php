<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BuildingUpdateProperties;
use AppBundle\Entity\BuildingUpdateTimers;
use AppBundle\Entity\Castle;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CastleController extends BaseController
{
    /**
     * @Route("/castles/{success}", name="user_castles")
     * @param Request $request
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Security("has_role('ROLE_USER')")
     */
    public function userCastlesAction(Request $request, bool $success = false)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $userId = $this->getUser()->getId();
        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));
        $currentDateTime = new \DateTime("now");
        $timeRemaining = array();
        $allUpdates = array();
        foreach ($castles as $castle)
        {
            $this->castleService->updateCastle($castle->getId());

            $updates = $this->em->getRepository(BuildingUpdateTimers::class)->findBy(array('castleId' => $castle->getId()));

            if ($updates)
            {
                foreach ($updates as $update)
                {
                    $tempInterval = date_diff($update->getFinishTime(), $currentDateTime);
                    $interval = $tempInterval->format('%H hours and %I minutes');
                    $allUpdates[] = $update;
                    $temp['id'] = $update->getId();
                    $temp['building'] = $update->getBuilding();
                    $temp['timeRemaining'] = $interval;
                    $timeRemaining[] = $temp;
                }
            }
        }
        return $this->render('view/castles.html.twig', array('castles' => $castles, 'allUpdates' => $allUpdates, 'timeRemaining' => $timeRemaining, 'success' => $success));
    }

    /**
     * @Route("/upgrade/{id}/{building}", name="upgrade")
     * @param string $building
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     * @throws \Exception
     */
    public function userUpgradeAction(int $id,string $building, Request $request)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $form = $this->createFormBuilder()->add('upgrade', SubmitType::class)->getForm();
        $form->handleRequest($request);

        $castle = $this->em->getRepository(Castle::class)->find($id);
        $this->castleService->updateCastle($castle->getId());

        /**
         * @var BuildingUpdateProperties $buildingUpdate
         */
        $buildingUpdate = $this->em->getRepository(BuildingUpdateProperties::class)->findOneBy(array('name' => $building));

        $costsArray = $this->castleService->purchaseBuildingCost($building, $castle, $buildingUpdate);
        list($foodCost, $metalCost, $updateTimer) = $costsArray;

        if (null == $castle)
        {
            throw $this->createNotFoundException('No castle found for id ' . $id);
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            try
            {
                $updates = $this->em->getRepository(BuildingUpdateTimers::class)->findBy(array('castleId' => $castle->getId()));

                foreach ($updates as $update)
                {
                    if ($castle->getId() == $update->getCastleId()->getId() && $update->getBuilding() == $building)
                    {
                        throw $exception = new Exception('Upgrade in progress');
                    }
                }
            }
            catch (Exception $exception)
            {
                $message = $exception->getMessage();
                return $this->render('view/upgrade.html.twig', array('form' => $form->createView(),
                    'building' => $building,
                    'foodCost' => $foodCost,
                    'metalCost' => $metalCost,
                    'updateTimer' => $updateTimer,
                    'message' => $message));
            }
            $message = $this->castleService->purchaseBuilding($building, $user, $castle, $buildingUpdate);

            if ($message)
            {
                return $this->render('view/upgrade.html.twig', array('form' => $form->createView(),
                    'building' => $building,
                    'foodCost' => $foodCost,
                    'metalCost' => $metalCost,
                    'updateTimer' => $updateTimer,
                    'message' => $message));
            }
            $success = true;
            return $this->redirectToRoute('user_castles', array('success' => $success));
        }
        return $this->render('view/upgrade.html.twig', array('form' => $form->createView(),
            'building' => $building,
            'foodCost' => $foodCost,
            'metalCost' => $metalCost,
            'updateTimer' => $updateTimer));
    }
}
