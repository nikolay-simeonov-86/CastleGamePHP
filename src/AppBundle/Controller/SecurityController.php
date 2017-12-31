<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Castle;
use AppBundle\Entity\User;
use AppBundle\Form\UserLogin;
use AppBundle\Form\UserRegister;
use AppBundle\Service\CastleServiceInterface;
use AppBundle\Service\UserService;
use AppBundle\Service\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
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
        $user = new User();
        $coordinates = $this->userService->setCoordinates();
        $user->setCoordinates($coordinates);

        $form = $this->createForm(UserRegister::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $castle1 = new Castle();
            $castle1->setName($form->get("castle1")->getData());
            if ($castle1->getName() === 'Dwarf')
            {
                $castle1->setCastleIcon('/pictures/Castles/DarkCastleDwarf.jpg');
            }
            else if ($castle1->getName() === 'Ninja')
            {
                $castle1->setCastleIcon('/pictures/Castles/DarkCastleNinja.jpg');
            }
            else if ($castle1->getName() === 'Vampire')
            {
                $castle1->setCastleIcon('/pictures/Castles/DarkCastleVampire.jpg');
            }
            else if ($castle1->getName() === 'Elves')
            {
                $castle1->setCastleIcon('/pictures/Castles/DarkCastleElves.jpg');
            }
            else if ($castle1->getName() === 'Mages')
            {
                $castle1->setCastleIcon('/pictures/Castles/DarkCastleMages.jpg');
            }
            else if ($castle1->getName() === 'Olymp')
            {
                $castle1->setCastleIcon('/pictures/Castles/DarkCastleOlymp.jpg');
            }

//dump($castle1);
//die();
            $castle2 = new Castle();
            $castle2->setName($form->get("castle2")->getData());
            if ($castle2->getName() === 'Dwarf')
            {
                $castle2->setCastleIcon('/pictures/Castles/DarkCastleDwarf.jpg');
            }
            else if ($castle2->getName() === 'Ninja')
            {
                $castle2->setCastleIcon('/pictures/Castles/DarkCastleNinja.jpg');
            }
            else if ($castle2->getName() === 'Vampire')
            {
                $castle2->setCastleIcon('/pictures/Castles/DarkCastleVampire.jpg');
            }
            else if ($castle2->getName() === 'Elves')
            {
                $castle2->setCastleIcon('/pictures/Castles/DarkCastleElves.jpg');
            }
            else if ($castle2->getName() === 'Mages')
            {
                $castle2->setCastleIcon('/pictures/Castles/DarkCastleMages.jpg');
            }
            else if ($castle2->getName() === 'Olymp')
            {
                $castle2->setCastleIcon('/pictures/Castles/DarkCastleOlymp.jpg');
            }


            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $castle1->setUserId($user->getId());
            $castle2->setUserId($user->getId());
            $em->persist($castle1);
            $em->persist($castle2);
            $em->flush();

            return $this->redirectToRoute("security_login");
        }
        return $this->render('view/register.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/login", name="security_login")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error,]);
        dump($error);
        die();
    }

    /**
     * @Route("/logout")
     * @throws \RuntimeException
     * @Security("has_role('ROLE_USER')")
     */
    public function logoutAction()
    {
        throw new \RuntimeException('This should never be called directly.');
    }
}
