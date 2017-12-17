<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('view/home.html.twig');
    }

    /**
     * @Route("/base", name="view_base_template")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function baseTemplateAction()
    {
        return $this->render('view/base.html.twig');
    }
}
