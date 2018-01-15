<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Castle;
use AppBundle\Entity\User;
use AppBundle\Repository\CastleRepository;
use AppBundle\Service\CastleServiceInterface;
use AppBundle\Service\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $query = $this->em->createQuery('SELECT c 
                                              FROM AppBundle\Entity\Castle c 
                                              WHERE c.userId = ?1');
        $query->setParameter(1, $userId);
        $castles = $query->getResult();

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

        $query = $this->em->createQuery('SELECT c 
                                              FROM AppBundle\Entity\Castle c 
                                              WHERE c.userId = ?1');
        $query->setParameter(1, $id);
        $castles = $query->getResult();

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
//dump($users);
//die();
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
        $query = $this->em->createQuery('SELECT c.id, c.name, c.armyLvl1Building, c.armyLvl2Building, c.armyLvl3Building, c.castleLvl, c.mineFoodLvl, c.mineMetalLvl, c.resourceFood, c.resourceMetal, c.castlePicture 
                                              FROM AppBundle\Entity\Castle c 
                                              WHERE c.userId = ?1');
        $query->setParameter(1, $userId);
        $castles = $query->getResult();
//        dump($castles);
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
     */
    public function userUpgradeAction(int $id,string $building, Request $request)
    {
        $form = $this->createFormBuilder()->add('Upgrade', SubmitType::class)->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $a = $this->em->getRepository(Castle::class)->find($id);
            if (!$a) {
                throw $this->createNotFoundException(
                    'No castle found for id ' . $id
                );
            }
            if ($building === 'castleLvl')
            {
                if ($a->getCastleLvl() === 0)
                {
                    $a->setCastleLvl('1');
                }
                elseif ($a->getCastleLvl() === 1)
                {
                    $a->setCastleLvl('2');
                }
                elseif ($a->getCastleLvl() === 2)
                {
                    $a->setCastleLvl('3');
                }
            }
            if ($building === 'mineFoodLvl')
            {
                if ($a->getMineFoodLvl() === 0)
                {
                    $a->setMineFoodLvl('1');
                }
                elseif ($a->getMineFoodLvl() === 1)
                {
                    $a->setMineFoodLvl('2');
                }
                elseif ($a->getMineFoodLvl() === 2)
                {
                    $a->setMineFoodLvl('3');
                }
            }
            if ($building === 'mineMetalLvl')
            {
                if ($a->getMineMetalLvl() === 0)
                {
                    $a->setMineMetalLvl('1');
                }
                elseif ($a->getMineMetalLvl() === 1)
                {
                    $a->setMineMetalLvl('2');
                }
                elseif ($a->getMineMetalLvl() === 2)
                {
                    $a->setMineMetalLvl('3');
                }
            }
            if ($building === 'mineFoodLvl')
            {
                if ($a->getMineFoodLvl() === 0)
                {
                    $a->setMineFoodLvl('1');
                }
                elseif ($a->getMineFoodLvl() === 1)
                {
                    $a->setMineFoodLvl('2');
                }
                elseif ($a->getMineFoodLvl() === 2)
                {
                    $a->setMineFoodLvl('3');
                }
            }
            if ($building === 'armyLvl1Building')
            {
                if ($a->getArmyLvl1Building() === 0)
                {
                    $a->setArmyLvl1Building('1');
                }
                elseif ($a->getArmyLvl1Building() === 1)
                {
                    $a->setArmyLvl1Building('2');
                }
                elseif ($a->getArmyLvl1Building() === 2)
                {
                    $a->setArmyLvl1Building('3');
                }
            }
            if ($building === 'armyLvl2Building')
            {
                if ($a->getArmyLvl2Building() === 0)
                {
                    $a->setArmyLvl2Building('1');
                }
                elseif ($a->getArmyLvl2Building() === 1)
                {
                    $a->setArmyLvl2Building('2');
                }
                elseif ($a->getArmyLvl2Building() === 2)
                {
                    $a->setArmyLvl2Building('3');
                }
            }
            if ($building === 'armyLvl3Building')
            {
                if ($a->getArmyLvl3Building() === 0)
                {
                    $a->setArmyLvl3Building('1');
                }
                elseif ($a->getArmyLvl3Building() === 1)
                {
                    $a->setArmyLvl3Building('2');
                }
                elseif ($a->getArmyLvl3Building() === 2)
                {
                    $a->setArmyLvl3Building('3');
                }
            }
            $this->em->flush();
            return $this->redirectToRoute('user_castles');
        }
        return $this->render('view/upgrade.html.twig', array('form' => $form->createView()));
    }
}
