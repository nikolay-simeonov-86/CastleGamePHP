<?php

namespace AppBundle\Controller;

use AppBundle\Service\CastleServiceInterface;
use AppBundle\Service\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class CastleController extends Controller
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
     * CastleController constructor.
     * @param UserServiceInterface $userService
     * @param CastleServiceInterface $castleService
     */
    public function __construct(UserServiceInterface $userService, CastleServiceInterface $castleService)
    {
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
        $information = $this->userService->getUserInformation();
        $income = $this->userService->calculateUserIncome();
        return $this->render( 'view/user.html.twig', array('information' => $information, 'income' => $income));
    }

    /**
     * @Route("/map", name="map")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     */
    public function viewMapAction()
    {
        return $this->render('view/map.html.twig');
    }
}
