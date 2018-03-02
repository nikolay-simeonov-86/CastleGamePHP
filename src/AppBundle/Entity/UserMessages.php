<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserMessages
 *
 * @ORM\Table(name="user_messages")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserMessagesRepository")
 */
class UserMessages
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sent_date", type="datetime")
     */
    private $sentDate;

    /**
     * @var string
     *
     * @ORM\Column(name="sender_username", type="string")
     */
    private $senderUsername;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @var bool
     *
     * @ORM\Column(name="visited", type="boolean")
     */
    private $visited;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userMessages")
     * @ORM\JoinColumn(name="user_id")
     */
    private $userId;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sentDate.
     *
     * @param \DateTime $sentDate
     *
     * @return UserMessages
     */
    public function setSentDate($sentDate)
    {
        $this->sentDate = $sentDate;

        return $this;
    }

    /**
     * Get sentDate.
     *
     * @return \DateTime
     */
    public function getSentDate()
    {
        return $this->sentDate;
    }

    /**
     * Set message.
     *
     * @param string $message
     *
     * @return UserMessages
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getSenderUsername(): string
    {
        return $this->senderUsername;
    }

    /**
     * @param string $senderUsername
     */
    public function setSenderUsername(string $senderUsername)
    {
        $this->senderUsername = $senderUsername;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set visited.
     *
     * @param bool $visited
     *
     * @return UserMessages
     */
    public function setVisited($visited)
    {
        $this->visited = $visited;

        return $this;
    }

    /**
     * Get visited.
     *
     * @return bool
     */
    public function getVisited()
    {
        return $this->visited;
    }

    /**
     * Set userId
     *
     * @param User $userId
     */
    public function setUserId(User $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get userId
     *
     * @return User
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
