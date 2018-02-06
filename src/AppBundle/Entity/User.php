<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=15, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var int
     *
     * @ORM\Column(name="coordinates", type="integer")
     */
    private $coordinates;

    /**
     * @var int
     *
     * @ORM\Column(name="food", type="integer")
     */
    private $food;

    /**
     * @var int
     *
     * @ORM\Column(name="metal", type="integer")
     */
    private $metal;

    /**
     * @var string
     *
     * @ORM\Column(name="castle_icon", type="string")
     */
    private $castleIcon;

    /**
     * @var Castle[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Castle", mappedBy="userId")
     */
    private $castles;

    /**
     * @var UserSpies[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserSpies", mappedBy="userId")
     */
    private $userSpies;

    public function __construct()
    {
        $this->userSpies = new ArrayCollection();
        $this->castles = new ArrayCollection();
        $this->food = 200;
        $this->metal = 0;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set coordinates
     *
     * @param integer $coordinates
     *
     * @return User
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * Get coordinates
     *
     * @return int
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set food
     *
     * @param integer $food
     *
     * @return User
     */
    public function setFood($food)
    {
        $this->food = $food;

        return $this;
    }

    /**
     * Get food
     *
     * @return int
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * Set metal
     *
     * @param integer $metal
     *
     * @return User
     */
    public function setMetal($metal)
    {
        $this->metal = $metal;

        return $this;
    }

    /**
     * Get metal
     *
     * @return int
     */
    public function getMetal()
    {
        return $this->metal;
    }

    /**
     * @return string
     */
    public function getCastleIcon()
    {
        return $this->castleIcon;
    }

    /**
     * @param string $castleIcon
     */
    public function setCastleIcon($castleIcon)
    {
        $this->castleIcon = $castleIcon;
    }

    /**
     * Set castles
     *
     * @param Castle[] $castles
     */
    public function setCastles(array $castles)
    {
        $this->castles = $castles;
    }

    /**
     * Get castles
     *
     * @return Collection|Castle[]
     */
    public function getCastles()
    {
        return $this->castles;
    }

    /**
     * Set userSpies
     *
     * @param UserSpies[] $userSpies
     */
    public function setUserSpies(array $userSpies)
    {
        $this->userSpies = $userSpies;
    }

    /**
     * Get userSpies
     *
     * @return Collection|UserSpies[]
     */
    public function getUserSpies()
    {
        return $this->userSpies;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}

