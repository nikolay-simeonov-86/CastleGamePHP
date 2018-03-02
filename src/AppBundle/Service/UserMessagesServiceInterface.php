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
    public function createNewMessage(User $user, string $receiver, string $formMessage);

    public function getUserMessagesAll(User $user);

    public function getUserMessagesAllUnread(User $user);

    public function getUserMessagesByUsername(User $user, string $username);
}