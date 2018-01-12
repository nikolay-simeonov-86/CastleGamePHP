<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('view/home.html.twig');
    }

    /**
     * @Route("/test", name="view_test_template")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function baseTemplateAction()
    {
        $query = $this->em->createQuery('SELECT u.id, u.username, u.coordinates, u.castleIcon FROM AppBundle\Entity\User u');
        $users = $query->getResult();
//        dump($users);
//        die();
        return $this->render('view/test.html.twig', array('users' => $users));
    }
}
