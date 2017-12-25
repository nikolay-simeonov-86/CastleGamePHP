<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Castle;
use AppBundle\Entity\User;
use AppBundle\Form\UserLogin;
use AppBundle\Form\UserRegister;
use AppBundle\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $user->setCoordinates(str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT));
        $form = $this->createForm(UserRegister::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $castle1 = new Castle();
            dump($form->get("castle1")->getData());
            $castle1->setName($form->get("castle1")->getData());

            $castle2 = new Castle();
            dump($form->get("castle2")->getData());
            $castle1->setName($form->get("castle2")->getData());

            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            //dump($user);
            $castle1->setUserId($user->getId());
            $em = $this->getDoctrine()->getManager();
            $em->persist($castle1);
            $em->flush();

            $castle2->setUserId($user->getId());
            $em = $this->getDoctrine()->getManager();
            $em->persist($castle2);
            $em->flush();

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
        dump('pesho');
        $error = $authenticationUtils->getLastAuthenticationError();
        dump($error);
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(UserLogin::class);
        return $this->render('view/login.html.twig', ['form'=>$form->createView(), 'last_username' => $lastUsername, 'error' => $error,]);
    }

    /**
     * @Route("/logout", name="logout")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \RuntimeException
     * @Security("has_role('ROLE_USER')")
     */
    public function logoutAction()
    {
        throw new \RuntimeException('This should never be called directly.');
    }

    /**
     * @Route("/user", name="user")
     * @param UserService $service
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userHomepage(UserService $service)
    {
        $information = $service->getUserInformation();
        $income = $service->calculateUserIncome();
        return $this->render( 'view/user.html.twig', array('information' => $information, 'income' => $income));
    }
}
