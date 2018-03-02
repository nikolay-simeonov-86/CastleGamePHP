<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 20.2.2018 г.
 * Time: 14:47 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use AppBundle\Entity\UserMessages;
use AppBundle\Repository\UserMessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class UserMessagesService implements UserMessagesServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserMessagesRepository
     */
    private $userMessagesRepository;

    /**
     * UserService constructor.
     * @param UserMessagesRepository $userMessagesRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(UserMessagesRepository $userMessagesRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->userMessagesRepository = $userMessagesRepository;
    }

    /**
     * @param User $user
     * @param string $receiver
     * @param string $formMessage
     * @return string
     */
    public function createNewMessage(User $user, string $receiver, string $formMessage)
    {
        try
        {
            $userMessage = $this->userMessagesRepository->findOneBy(array(),array('id'=>'DESC'));
            $currentDateTime = new \DateTime("now");
            $tempInterval = date_diff($userMessage->getSentDate(), $currentDateTime);
            $interval = $tempInterval->format("%y %m %d %h %i %s");
            list($year, $month, $day, $hour, $minute, $second) = array_map('intval', explode(' ', $interval));
            $seconds = (int)floor(((($year * 365.25 + $month * 30 + $day) * 24 + $hour) * 60 + $minute)*60 + $second);
            $minSeconds = 20;
            if ($seconds < $minSeconds)
            {
                $timeLeft = $minSeconds - $seconds;
                throw $exception = new Exception("$timeLeft seconds left (no spam)");
            }
            else
            {
                if ($this->em->getRepository(User::class)->findOneBy(array('username' => $receiver)))
                {
                    $receiverUser = $this->em->getRepository(User::class)->findOneBy(array('username' => $receiver));

                    if (strlen(trim(preg_replace('/\s+/', ' ', $formMessage))) <= 255 &&
                        strlen(trim(preg_replace('/\s+/', ' ', $formMessage))) >= 1)
                    {
                        $newMessage = new UserMessages();
                        $newMessage->setVisited(0);
                        $newMessage->setSenderUsername($user->getUsername());
                        $newMessage->setSentDate(new \DateTime("now"));
                        $newMessage->setMessage($formMessage);
                        $newMessage->setUserId($receiverUser);
                        $this->em->persist($newMessage);
                        $this->em->flush();

                        return null;
                    }
                    else
                    {
                        throw $exception = new Exception('Invalid message length');
                    }
                }
                else
                {
                    throw $exception = new Exception('Username does not exist');
                }
            }
        }
        catch (\Exception $exception)
        {
            $message = $exception->getMessage();
            return $message;
        }
    }

    public function getUserMessagesAll(User $user)
    {
        // TODO: Implement getUserMessagesAll() method.
    }

    /**
     * @param User $user
     * @return int
     */
    public function getUserMessagesAllUnread(User $user)
    {
        $allUnvisitedMessages = $this->userMessagesRepository->findBy(array('userId' => $user, 'visited' => false));
        $count = 0;
        foreach ($allUnvisitedMessages as $unvisitedMessage)
        {
            $count++;
        }
        return $count;
    }

    public function getUserMessagesByUsername(User $user, string $username)
    {
        // TODO: Implement getUserMessagesByUsername() method.
    }
}