<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserLogin;
use AppBundle\Form\UserRegister;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction()
    {
        $form = $this->createForm(UserRegister::class);
        return $this->render('view/register.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/map", name="map")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewMapAction()
    {
        return $this->render('view/map.html.twig');
    }

    /**
     * @Route("/login", name="login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $form = $this->createForm(UserLogin::class);
        return $this->render('view/login.html.twig', ['form'=>$form->createView()]);
    }
}
