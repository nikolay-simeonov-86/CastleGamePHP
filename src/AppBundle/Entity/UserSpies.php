<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSpies
 *
 * @ORM\Table(name="user_spies")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserSpiesRepository")
 */
class UserSpies
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
     * @var int
     *
     * @ORM\Column(name="target_user_id", type="smallint")
     */
    private $targetUserId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiration_date", type="datetime")
     */
    private $expirationDate;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userSpies")
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
     * Set targetUserId.
     *
     * @param int $targetUserId
     *
     * @return UserSpies
     */
    public function setTargetUserId($targetUserId)
    {
        $this->targetUserId = $targetUserId;

        return $this;
    }

    /**
     * Get targetUserId.
     *
     * @return int
     */
    public function getTargetUserId()
    {
        return $this->targetUserId;
    }

    /**
     * Set expirationDate.
     *
     * @param \DateTime $expirationDate
     *
     * @return UserSpies
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate.
     *
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
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
