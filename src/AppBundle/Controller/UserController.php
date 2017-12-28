<?php

namespace AppBundle\Controller;

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

class UserController extends Controller
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
     * UserController constructor.
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
            $castle1 = $this->castleService->buildCastle($form->get("castle1")->getData());

            $castle2 = $this->castleService->buildCastle($form->get("castle2")->getData());

            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

//            dump($user);
            $castle1->setUserId($user->getId());
            $castle2->setUserId($user->getId());
            $em = $this->getDoctrine()->getManager();
            $em->persist($castle1);
            $em->persist($castle2);
            $em->flush();

//            dump($castle1);
//            dump($castle2);
//            die();
            return $this->redirectToRoute("login");
        }
        return $this->render('view/register.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        //dump('pesho');
        $error = $authenticationUtils->getLastAuthenticationError();
        //dump($error);
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(UserLogin::class);
        $form->handleRequest($request);
        return $this->render('view/login.html.twig', ['form'=>$form->createView(), 'last_username' => $lastUsername, 'error' => $error,]);
    }

    /**
     * @Route("/logout", name="logout")
     * @throws \RuntimeException
     * @Security("has_role('ROLE_USER')")
     */
    public function logoutAction()
    {
        throw new \RuntimeException('This should never be called directly.');
    }
}
