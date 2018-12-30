<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Army;
use AppBundle\Entity\User;
use AppBundle\Entity\UserSpies;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Castle;
use AppBundle\Entity\NewCastleCost;

class UserController extends BaseController
{
    /**
     * @Route("/logged_user/{success}", name="user")
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userHomepageAction(bool $success = false)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);
        $userId = $user->getId();

//        $this->userUpdateResourcesService->updateUsersResources();

        $newCastleCostsArray = $this->em->getRepository(NewCastleCost::class)->findAll();
        list($newCastleCosts) = $newCastleCostsArray;

        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));
        foreach ($castles as $castle)
        {
            $this->castleService->updateCastle($castle->getId());
        }

        return $this->render( 'view/user.html.twig', array('castles' => $castles, 'user' => $user, 'newCastleCosts' => $newCastleCosts, 'success' => $success));
    }

    /**
     * @Route("/user/buy/castle", name="user_buy_castle")
     * @param Request $request
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userBuyNewCastle(Request $request)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $userId = $user->getId();
        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));

        $form = $this->createFormBuilder()
            ->add('Select', ChoiceType::class,
                array(
                    'mapped' => false,
                    'choices'  =>
                        array(
                            'Dark' =>
                                array(
                                    'Dwarf' => 'Dwarf',
                                    'Ninja' => 'Ninja',
                                    'Vampire' => 'Vampire'
                                ),
                            'Light' =>
                                array(
                                    'Elfs' => 'Elfs',
                                    'Mages' => 'Mages',
                                    'Olymp' => 'Olymp'
                                ),
                        ),
                )
            )
            ->add('Confirm', SubmitType::class,
                array('attr' => array('type' => 'button', 'class' => 'btn btn-lg btn-success bodytext cursor-pointer send-a-message-button')))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $message = $this->newCastleCostService->calculateCostForNewCastle($user);

            if ($message)
            {
                return $this->render('view/user_buy_castle.html.twig', array('form' => $form->createView(),
                    'castles' => $castles,
                    'message' => $message));
            }
            else
            {
                $this->newCastleCostService->buildNewCastle($user, $form->get('Select')->getData());
                $success = true;
                return $this->redirectToRoute('user', array('success' => $success));
            }
        }

        return $this->render('view/user_buy_castle.html.twig', array('form' => $form->createView(),
            'castles' => $castles));
    }

    /**
     * @Route("/user/{id}", name="user_profile")
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @Security("has_role('ROLE_USER')")
     */
    public function userProfileAction(int $id, Request $request)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

//        $this->userUpdateResourcesService->updateUsersResources();

        if ($this->getUser()->getId() === $id)
        {
            return $this->redirectToRoute('user');
        }

        if ($this->em->getRepository(User::class)->find($id))
        {
            $user = $this->em->getRepository(User::class)->find($id);
            $userId = $user->getId();
        }
        else
        {
            return $this->redirectToRoute('map');
        }

        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));
        $count = 0;
        foreach ($castles as $castle)
        {
            if ($count == 0)
            {
                $mainCastleId = $castle->getId();
            }
            $this->castleService->updateCastle($castle->getId());
            $count++;
        }

        $loggedUser = $this->getUser();
        $this->userSpiesService->expireUserSpy($loggedUser);

        $form = $this->createFormBuilder()->add('spy', SubmitType::class)->getForm();
        $form->handleRequest($request);

        if ($this->em->getRepository(UserSpies::class)->findOneBy(array('userId' => $loggedUser, 'targetUserId' => $id)))
        {
            $userSpyCheck = $this->em->getRepository(UserSpies::class)->findOneBy(array('userId' => $loggedUser, 'targetUserId' => $id));
            $currentDateTime = new \DateTime("now");

            if ($userSpyCheck->getStartDate() < $currentDateTime)
            {
                $tempInterval = date_diff($userSpyCheck->getExpirationDate(), $currentDateTime);
                $interval = $tempInterval->format('%I minutes');
                $armyAll = $this->em->getRepository(Army::class)->findBy(array('castleId' => $mainCastleId));
                return $this->render( 'view/user_profile.html.twig', array('form' => $form->createView(),
                    'castles' => $castles,
                    'user' => $user,
                    'interval' => $interval,
                    'armyAll' => $armyAll));
            }
            else
            {
                $tempInterval = date_diff($userSpyCheck->getStartDate(), $currentDateTime);
                $timeLeft = $tempInterval->format('%H hours and %I minutes');
                return $this->render( 'view/user_profile.html.twig', array('form' => $form->createView(),
                    'castles' => $castles,
                    'user' => $user,
                    'timeLeft' => $timeLeft));
            }
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            $message = $this->userSpiesService->purchaseUserSpy($loggedUser);
            if ($message)
            {
                return $this->render( 'view/user_profile.html.twig', array('form' => $form->createView(),
                    'castles' => $castles,
                    'user' => $user,
                    'message' => $message));
            }
            $this->userSpiesService->createUserSpy($loggedUser, $id);

            return $this->redirectToRoute('user_profile', array('id' => $id));
        }

        return $this->render( 'view/user_profile.html.twig', array('form' => $form->createView(),
            'castles' => $castles,
            'user' => $user));
    }
}
