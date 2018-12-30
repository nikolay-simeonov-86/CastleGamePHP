<?php

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MapController extends BaseController
{
    /**
     * @Route("/map", name="map")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')")
     */
    public function viewMapAction()
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $user = $this->getUser();
            $this->updateUserMessageNotifications($user);
        }

        $query = $this->em->createQuery('SELECT u.id, u.username, u.coordinates, u.castleIcon 
                                              FROM AppBundle\Entity\User u');
        $users = $query->getResult();

        return $this->render('view/map.html.twig', array('users' => $users));
    }
}
