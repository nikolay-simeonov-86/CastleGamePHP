<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Castle;
use AppBundle\Entity\User;
use AppBundle\Repository\CastleRepository;
use AppBundle\Service\CastleServiceInterface;
use AppBundle\Service\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CastleController extends Controller
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
     * @return \Symfony\Component\HttpFoundation\Response* @Security("has_role('ROLE_USER')")
     */
    public function userHomepageAction()
    {
        $user = $this->getUser();
        $userId = $user->id;
        $query = $this->em->createQuery('SELECT c FROM AppBundle\Entity\Castle c WHERE c.userId = ?1');
        $query->setParameter(1, $userId);
        $castles = $query->getResult();
//        dump($userId);
//        dump($user);
//        dump($castle);
//        die();
        return $this->render( 'view/user.html.twig', array('castles' => $castles, 'user' => $user));
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
