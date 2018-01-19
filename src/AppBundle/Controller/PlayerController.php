<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BuildingUpdateTimers;
use AppBundle\Entity\Castle;
use AppBundle\Entity\User;
use AppBundle\Repository\CastleRepository;
use AppBundle\Service\CastleServiceInterface;
use AppBundle\Service\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PlayerController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var CastleServiceInterface
     */
    private $castleService;

    /**
     * CastleController constructor.
     * @param UserServiceInterface $userService
     * @param CastleServiceInterface $castleService
     * @param EntityManagerInterface $em
     */
    public function __construct(UserServiceInterface $userService, CastleServiceInterface $castleService, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->userService = $userService;
        $this->castleService = $castleService;
    }

    /**
     * @Route("/user", name="user")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userHomepageAction()
    {
        $user = $this->getUser();
        $userId = $user->getId();

        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));
        foreach ($castles as $castle)
        {
            $this->castleService->updateCastle($castle->getId());
        }

//        dump($castles);
//        die();

        return $this->render( 'view/user.html.twig', array('castles' => $castles, 'user' => $user));
    }

    /**
     * @Route("/user/{id}", name="user_profile")
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userProfileAction(int $id, Request $request)
    {
        $user = $this->getUser();
        $userId = $user->getId();

        if ($userId === $id)
        {
            return $this->redirectToRoute('user');
        }

        $query = $this->em->createQuery('SELECT u 
                                              FROM AppBundle\Entity\User u 
                                              WHERE u.id = ?1');
        $query->setParameter(1, $id);
        $user = $query->getResult();

        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));
        foreach ($castles as $castle)
        {
            $this->castleService->updateCastle($castle->getId());
        }

        return $this->render( 'view/user_profile.html.twig', array('castles' => $castles, 'user' => $user));
    }

    /**
     * @Route("/map", name="map")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     */
    public function viewMapAction()
    {
        $query = $this->em->createQuery('SELECT u.id, u.username, u.coordinates, u.castleIcon 
                                              FROM AppBundle\Entity\User u');
        $users = $query->getResult();

        return $this->render('view/map.html.twig', array('users' => $users));
    }

    /**
     * @Route("/castles", name="user_castles")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userCastlesAction(Request $request)
    {
        $userId = $this->getUser()->getId();
        $castles = $this->em->getRepository(Castle::class)->findBy(array('userId' => $userId));
        foreach ($castles as $castle)
        {
            $this->castleService->updateCastle($castle->getId());
        }
//        dump($updates);
//        dump($castle);
//        die();
        return $this->render('view/castles.html.twig', array('castles' => $castles));
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
        $form = $this->createFormBuilder()->add('upgrade', SubmitType::class)->getForm();
        $form->handleRequest($request);

        $user = $this->getUser();

        $castle = $this->em->getRepository(Castle::class)->find($id);
        $this->castleService->updateCastle($castle->getId());

        if (null == $castle)
        {
            throw $this->createNotFoundException('No castle found for id ' . $id);
        }

        if ($form->isSubmitted() && $form->isValid())
        {
            try
            {
                $finishDate = new BuildingUpdateTimers();
                $finishDate->setCastleId($castle);
                $finishDate->setBuilding($building);
                $startDate = new \DateTime;
                $finishDate->setFinishTime($startDate->add(new \DateInterval('PT1M')));

                if ($building === 'Castle')
                {
                    if ($castle->getCastleLvl() === 0)
                    {
                        $food = $user->getFood();
                        $foodafter = $food - 100;
                        $metalafter = null;
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        $user->setFood($foodafter);
                        $finishDate->setUpgradeToLvl(1);
                    }
                    elseif ($castle->getCastleLvl() === 1)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 500;
                        $metalafter = $metal - 500;
                        if ($castle->getArmyLvl1Building() == 0)
                        {
                            throw $exception = new Exception('You need to build Footmen first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(2);
                    }
                    elseif ($castle->getCastleLvl() === 2)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 1500;
                        $metalafter = $metal - 1500;
                        if ($castle->getArmyLvl1Building() == 0)
                        {
                            throw $exception = new Exception('You need to build Footmen first');
                        }
                        if ($castle->getArmyLvl2Building() == 0)
                        {
                            throw $exception = new Exception('You need to build Archers first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(3);
                    }
                }
                if ($building === 'Farm')
                {
                    if ($castle->getMineFoodLvl() === 0)
                    {
                        $food = $user->getFood();
                        $foodafter = $food - 100;
                        $metalafter = null;
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        $user->setFood($foodafter);
                        $finishDate->setUpgradeToLvl(1);
                    }
                    elseif ($castle->getMineFoodLvl() === 1)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 250;
                        $metalafter = $metal - 100;
                        if ($castle->getCastleLvl() == 0)
                        {
                            throw $exception = new Exception('You need to build Castle first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(2);
                    }
                    elseif ($castle->getMineFoodLvl() === 2)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 500;
                        $metalafter = $metal - 250;
                        if ($castle->getCastleLvl() <= 1)
                        {
                            throw $exception = new Exception('You need to build Castle level 2 first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(3);
                    }
                }
                if ($building === 'Metal Mine')
                {
                    if ($castle->getMineMetalLvl() === 0)
                    {
                        $food = $user->getFood();
                        $foodafter = $food - 200;
                        $metalafter = null;
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        $user->setFood($foodafter);
                        $finishDate->setUpgradeToLvl(1);
                    }
                    elseif ($castle->getMineMetalLvl() === 1)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 300;
                        $metalafter = $metal - 300;
                        if ($castle->getCastleLvl() == 0)
                        {
                            throw $exception = new Exception('You need to build Castle first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(2);
                    }
                    elseif ($castle->getMineMetalLvl() === 2)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 500;
                        $metalafter = $metal - 500;
                        if ($castle->getCastleLvl() <= 1)
                        {
                            throw $exception = new Exception('You need to build Castle level 2 first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(3);
                    }
                }
                if ($building === 'Footmen')
                {
                    if ($castle->getArmyLvl1Building() === 0)
                    {
                        $food = $user->getFood();
                        $foodafter = $food - 500;
                        $metalafter = null;
                        if ($castle->getCastleLvl() == 0)
                        {
                            throw $exception = new Exception('You need to build Castle first');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        $user->setFood($foodafter);
                        $finishDate->setUpgradeToLvl(1);
                    }
                    elseif ($castle->getArmyLvl1Building() === 1)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 1000;
                        $metalafter = $metal - 500;
                        if ($castle->getCastleLvl() <= 1)
                        {
                            throw $exception = new Exception('You need to build Castle level 2 first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(2);
                    }
                    elseif ($castle->getArmyLvl1Building() === 2)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 1500;
                        $metalafter = $metal - 1000;
                        if ($castle->getCastleLvl() <= 2)
                        {
                            throw $exception = new Exception('You need to build Castle level 3 first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(3);
                    }
                }
                if ($building === 'Archers')
                {
                    if ($castle->getArmyLvl2Building() === 0)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 500;
                        $metalafter = $metal - 500;
                        if ($castle->getCastleLvl() == 0)
                        {
                            throw $exception = new Exception('You need to build Castle first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(1);
                    }
                    elseif ($castle->getArmyLvl2Building() === 1)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 1000;
                        $metalafter = $metal - 1000;
                        if ($castle->getCastleLvl() <= 1)
                        {
                            throw $exception = new Exception('You need to build Castle level 2 first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(2);
                    }
                    elseif ($castle->getArmyLvl2Building() === 2)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 1500;
                        $metalafter = $metal - 1500;
                        if ($castle->getCastleLvl() <= 2)
                        {
                            throw $exception = new Exception('You need to build Castle level 3 first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(3);
                    }
                }
                if ($building === 'Cavalry')
                {
                    if ($castle->getArmyLvl3Building() === 0)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 1000;
                        $metalafter = $metal - 1000;
                        if ($castle->getCastleLvl() == 0)
                        {
                            throw $exception = new Exception('You need to build Castle first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(1);
                    }
                    elseif ($castle->getArmyLvl3Building() === 1)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 2000;
                        $metalafter = $metal - 2000;
                        if ($castle->getCastleLvl() <= 1)
                        {
                            throw $exception = new Exception('You need to build Castle level 2 first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(2);
                    }
                    elseif ($castle->getArmyLvl3Building() === 2)
                    {
                        $food = $user->getFood();
                        $metal = $user->getMetal();
                        $foodafter = $food - 3500;
                        $metalafter = $metal - 3500;
                        if ($castle->getCastleLvl() <= 2)
                        {
                            throw $exception = new Exception('You need to build Castle level 3 first');
                        }
                        if ($foodafter < 0 && $metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough resources to upgrade');
                        }
                        if ($foodafter < 0)
                        {
                            throw $exception = new Exception('Not enough food to upgrade');
                        }
                        if ($metalafter < 0)
                        {
                            throw $exception = new Exception('Not enough metal to upgrade');
                        }
                        $user->setFood($foodafter);
                        $user->setMetal($metalafter);
                        $finishDate->setUpgradeToLvl(3);
                    }
                }
                $this->em->persist($finishDate);
                $this->em->flush();
                return $this->redirectToRoute('user_castles');
            }
            catch (Exception $exception)
            {
                $message = $exception->getMessage();
                return $this->render('view/upgrade.html.twig', array('form' => $form->createView(), 'building' => $building, 'message' => $message, 'foodafter' => $foodafter, 'metalafter' => $metalafter));
            }
        }
        return $this->render('view/upgrade.html.twig', array('form' => $form->createView(), 'building' => $building));
    }

    /**
     * @Route("/army", name="user_army")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userArmyAction(Request $request)
    {
        $userId = $this->getUser()->getId();

        $castles = $this->em->getRepository(Castle::class)->find($userId);
        $this->castleService->updateCastle($castles->getId());
//        dump($castles);
//        die();
        return $this->render('view/army.html.twig', array('castles' => $castles));
    }
}
