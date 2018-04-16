<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 20.2.2018 г.
 * Time: 14:44 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use AppBundle\Repository\UserMessagesRepository;

interface UserMessagesServiceInterface
{
    /**
     * @param User $user
     * @param string $receiver
     * @param string $formMessage
     * @return mixed
     */
    public function createNewMessage(User $user, string $receiver, string $formMessage);

    /**
     * @param User $user
     * @return mixed
     */
    public function getUserMessagesAll(User $user);

    /**
     * @param User $user
     * @return mixed
     */
    public function getUserMessagesAllUnread(User $user);

    /**
     * @param User $user
     * @param string $username
     * @return mixed
     */
    public function getUserMessagesByUsername(User $user, string $username);
}