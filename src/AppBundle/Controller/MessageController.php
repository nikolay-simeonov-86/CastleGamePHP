<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserMessages;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends BaseController
{
    /**
     * @Route("/messages/inbox/{page}/{success}", name="user_messages_inbox")
     * @param int $page
     * @param Request $request
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userMessagesInboxAction(int $page = 0, Request $request, bool $success = false)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $countPerPage = 8;

        $countQuery = $this->em->createQueryBuilder()
            ->select('Count(DISTINCT u.senderUsername)')
            ->from('AppBundle:UserMessages', 'u')
            ->where('u.userId = ?1')
            ->setParameter(1, $user);
        $finalCountQuery = $countQuery->getQuery();
        try {
            $totalCount = $finalCountQuery->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            $totalCount = 0;
        }

        if ($totalCount>0)
        {
            $totalPages=ceil($totalCount/$countPerPage);

            if(!is_numeric($page)){
                $page=1;
            }
            else{
                $page=floor($page);
            }
            if($totalCount<=$countPerPage){
                $page=1;
            }
            if(($page*$countPerPage)>$totalCount){
                $page=$totalPages;
            }
            $offset=0;
            if($page>1){
                $offset = $countPerPage * ($page-1);
            }
            $visualQuery = $this->em->createQueryBuilder()
                ->select('DISTINCT(u.senderUsername), COUNT(u.message), MAX(u.sentDate)')
                ->from('AppBundle:UserMessages', 'u')
                ->where('u.userId = ?1')
                ->groupBy('u.senderUsername')
                ->orderBy('u.sentDate', 'DESC')
                ->setParameter(1, $user)
                ->setFirstResult($offset)
                ->setMaxResults($countPerPage);
            $visualFinalQuery = $visualQuery->getQuery();
            $finalTableArrayResult = $visualFinalQuery->getArrayResult();
        }
        else
        {
            $finalTableArrayResult = [];
            $totalPages = 0;
        }

        return $this->render('view/user_messages_inbox.html.twig', array('finalTableArrayResult'=>$finalTableArrayResult,
            'totalPages'=>$totalPages,
            'currentPage'=> $page,
            'success' => $success));
    }

    /**
     * @Route("/messages/inbox/sender/{sender}/{page}/{success}", name="user_messages_inbox_sender")
     * @param string $sender
     * @param int $page
     * @param Request $request
     * @param bool $success
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userMessagesInboxSenderAction(string $sender, $page = 0, Request $request, bool $success = false)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $countPerPage = 2;

        $countQuery = $this->em->createQueryBuilder()
            ->select('COUNT(u.message)')
            ->from('AppBundle:UserMessages', 'u')
            ->where('u.userId = ?1 AND u.senderUsername = ?2')
            ->setParameter(1, $user)
            ->setParameter(2, $sender);
        $finalCountQuery = $countQuery->getQuery();
        try {
            $totalCount = $finalCountQuery->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            $totalCount = 0;
        }

        if ($totalCount>0)
        {
            $totalPages=ceil($totalCount/$countPerPage);

            if(!is_numeric($page)){
                $page=1;
            }
            else{
                $page=floor($page);
            }
            if($totalCount<=$countPerPage){
                $page=1;
            }
            if(($page*$countPerPage)>$totalCount){
                $page=$totalPages;
            }
            $offset=0;
            if($page>1){
                $offset = $countPerPage * ($page-1);
            }
            $visualQuery = $this->em->createQueryBuilder()
                ->select('u.id, u.senderUsername, u.message, TRIM(u.sentDate)')
                ->from('AppBundle:UserMessages', 'u')
                ->where('u.userId = ?1 AND u.senderUsername = ?2')
                ->orderBy('u.sentDate', 'DESC')
                ->setParameter(1, $user)
                ->setParameter(2, $sender)
                ->setFirstResult($offset)
                ->setMaxResults($countPerPage);
            $visualFinalQuery = $visualQuery->getQuery();
            $finalTableArrayResult = $visualFinalQuery->getArrayResult();

            $sendersMessages = $this->em->getRepository(UserMessages::class)->findBy(array('userId' => $user, 'senderUsername' => $sender));
            foreach ($sendersMessages as $sendersMessage)
            {
                $sendersMessage->setVisited(true);
                $this->em->persist($sendersMessage);
                $this->em->flush();
            }
        }
        else
        {
            $finalTableArrayResult = [];
            $totalPages = 0;
        }

        return $this->render('view/user_messages_inbox_sender.html.twig', array('finalTableArrayResult'=>$finalTableArrayResult,
            'totalPages'=>$totalPages,
            'currentPage'=> $page,
            'sender' => $sender,
            'success' => $success));
    }

    /**
     * @Route("/messages/inbox/delete/{sender}/{page}/{id}", name="user_messages_inbox_sender_delete")
     * @param string $sender
     * @param int $page
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userMessagesInboxSenderDeleteAction(string $sender, int $page, int $id, Request $request)
    {
        $user = $this->getUser();

        if (null == $this->em->getRepository(UserMessages::class)->findOneBy(array('id' => $id)))
        {
            return $this->redirectToRoute('user_messages_inbox_sender', array('sender' => $sender, 'page' => $page));
        }

        $message = $this->em->getRepository(UserMessages::class)->findOneBy(array('id' => $id));

        if ($message->getUserId() != $user)
        {
            return $this->redirectToRoute('user_messages_inbox_sender', array('sender' => $sender, 'page' => $page));
        }

        $this->em->remove($message);
        $this->em->flush();

        return $this->redirectToRoute('user_messages_inbox_sender', array('sender' => $sender, 'page' => $page));
    }

    /**
     * @Route("/messages/send/", name="user_messages_send")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userMessagesSendAction(Request $request)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $form = $this->createFormBuilder()
            ->add('receiver', TextType::class)
            ->add('message', TextareaType::class, array('attr' => array('class' => 'textarea', 'maxlength' => '250', 'rows' => '5', 'wrap' => 'hard', 'cols' => '50')))
            ->add('Send', SubmitType::class, array('attr' => array('type' => 'button', 'class' => 'btn btn-lg btn-success bodytext cursor-pointer send-a-message-button')))
            ->getForm();
        $form->handleRequest($request);

        $receiver = $form->get('receiver')->getData();
        $formMessage = trim(preg_replace('/\s+/', ' ', $form->get('message')->getData()));

        if ($form->isSubmitted() && $form->isValid())
        {
            $message = $this->userMessagesService->createNewMessage($user, $receiver, $formMessage);
            if ($message)
            {
                return $this->render('view/user_messages_send.html.twig', array('form' => $form->createView(),
                    'message' => $message));
            }
            else
            {
                $success = true;
                return $this->redirectToRoute('user_messages_inbox', array('success' => $success));
            }
        }
        return $this->render('view/user_messages_send.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/messages/send/{receiver}", name="user_messages_send_to_receiver")
     * @param string $receiver
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function userMessagesSendToReceiverAction(string $receiver, Request $request)
    {
        $user = $this->getUser();
        $this->updateUserMessageNotifications($user);

        $form = $this->createFormBuilder()
            ->add('message', TextareaType::class, array('attr' => array('class' => 'textarea', 'maxlength' => '250', 'rows' => '5', 'wrap' => 'hard', 'cols' => '50')))
            ->add('Send', SubmitType::class, array('attr' => array('type' => 'button', 'class' => 'btn btn-lg btn-success bodytext cursor-pointer send-a-message-button')))
            ->getForm();
        $form->handleRequest($request);

        $formMessage = trim(preg_replace('/\s+/', ' ', $form->get('message')->getData()));

        if ($form->isSubmitted() && $form->isValid())
        {
            $message = $this->userMessagesService->createNewMessage($user, $receiver, $formMessage);
            if ($message)
            {
                return $this->render('view/user_messages_send_to_receiver.html.twig', array('form' => $form->createView(),
                    'message' => $message,
                    'receiver' => $receiver));
            }
            else
            {
                $success = true;
                return $this->redirectToRoute('user_messages_inbox_sender', array('sender' => $receiver,
                    'page' => 1,
                    'success' => $success));
            }
        }
        return $this->render('view/user_messages_send_to_receiver.html.twig', array('form' => $form->createView(),
            'receiver' => $receiver));
    }
}
