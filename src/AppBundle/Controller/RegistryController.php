<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Castle;
use AppBundle\Entity\User;
use AppBundle\Form\UserRegister;
use AppBundle\Service\CastleServiceInterface;
use AppBundle\Service\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistryController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var CastleServiceInterface
     */
    private $castleService;

    /**
     * SecurityController constructor.
     * @param UserServiceInterface $userService
     * @param CastleServiceInterface $castleService
     */
    public function __construct(UserServiceInterface $userService, CastleServiceInterface $castleService)
    {
        $this->userService = $userService;
        $this->castleService = $castleService;
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     */
    public function registerAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('user');
        }

        $user = new User();
        $form = $this->createForm(UserRegister::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setCastleIcon($form->get('castle1')->getData());
            if ($form->get('castle1')->getData() === 'Dwarf') {
                $user->setCastleIcon('/pictures/CastleIcons/DwarfIconSmall.jpg');
            } else if ($form->get('castle1')->getData() === 'Ninja') {
                $user->setCastleIcon('/pictures/CastleIcons/NinjaIconSmall.jpg');
            } else if ($form->get('castle1')->getData() === 'Vampire') {
                $user->setCastleIcon('/pictures/CastleIcons/VampireIconSmall.jpg');
            } else if ($form->get('castle1')->getData() === 'Elves') {
                $user->setCastleIcon('/pictures/CastleIcons/ElvesIconSmall.jpg');
            } else if ($form->get('castle1')->getData() === 'Mages') {
                $user->setCastleIcon('/pictures/CastleIcons/MageIconSmall.jpg');
            } else if ($form->get('castle1')->getData() === 'Olymp') {
                $user->setCastleIcon('/pictures/CastleIcons/OlympIconSmall.jpg');
            }

            $coordinates = $this->userService->setCoordinates();
            $user->setCoordinates($coordinates);

            $castle1 = new Castle();
            $castle1->setName($form->get("castle1")->getData());
            if ($castle1->getName() === 'Dwarf') {
                $castle1->setCastlePicture('/pictures/Castles/DarkCastleDwarf.jpg');
            } else if ($castle1->getName() === 'Ninja') {
                $castle1->setCastlePicture('/pictures/Castles/DarkCastleNinja.jpg');
            } else if ($castle1->getName() === 'Vampire') {
                $castle1->setCastlePicture('/pictures/Castles/DarkCastleVampire.jpg');
            } else if ($castle1->getName() === 'Elves') {
                $castle1->setCastlePicture('/pictures/Castles/LightCastleElves.jpg');
            } else if ($castle1->getName() === 'Mages') {
                $castle1->setCastlePicture('/pictures/Castles/LightCastleMages.jpg');
            } else if ($castle1->getName() === 'Olymp') {
                $castle1->setCastlePicture('/pictures/Castles/LightCastleOlymp.jpg');
            }

            $castle2 = new Castle();
            $castle2->setName($form->get("castle2")->getData());
            if ($castle2->getName() === 'Dwarf') {
                $castle2->setCastlePicture('/pictures/Castles/DarkCastleDwarf.jpg');
            } else if ($castle2->getName() === 'Ninja') {
                $castle2->setCastlePicture('/pictures/Castles/DarkCastleNinja.jpg');
            } else if ($castle2->getName() === 'Vampire') {
                $castle2->setCastlePicture('/pictures/Castles/DarkCastleVampire.jpg');
            } else if ($castle2->getName() === 'Elves') {
                $castle2->setCastlePicture('/pictures/Castles/LightCastleElves.jpg');
            } else if ($castle2->getName() === 'Mages') {
                $castle2->setCastlePicture('/pictures/Castles/LightCastleMages.jpg');
            } else if ($castle2->getName() === 'Olymp') {
                $castle2->setCastlePicture('/pictures/Castles/LightCastleOlymp.jpg');
            }

            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $castle1->setUserId($user);
            $castle2->setUserId($user);
            $em->persist($castle1);
            $em->persist($castle2);
            $em->flush();

            return $this->redirectToRoute("security_login");
        }
        return $this->render('view/register.html.twig', ['form' => $form->createView()]);
    }
}
