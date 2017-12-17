<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(name="username", type="string", length=50, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=50)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="coordinates", type="string", length=50, unique=true)
     */
    private $coordinates;

    /**
     * @var int
     *
     * @ORM\Column(name="castles", type="integer")
     */
    private $castles;

    /**
     * @var int
     *
     * @ORM\Column(name="income_all", type="integer")
     */
    private $incomeAll;


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
     * @param string $coordinates
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
     * @return string
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set castles
     *
     * @param integer $castles
     *
     * @return User
     */
    public function setCastles($castles)
    {
        $this->castles = $castles;

        return $this;
    }

    /**
     * Get castles
     *
     * @return int
     */
    public function getCastles()
    {
        return $this->castles;
    }

    /**
     * Set incomeAll
     *
     * @param integer $incomeAll
     *
     * @return User
     */
    public function setIncomeAll($incomeAll)
    {
        $this->incomeAll = $incomeAll;

        return $this;
    }

    /**
     * Get incomeAll
     *
     * @return int
     */
    public function getIncomeAll()
    {
        return $this->incomeAll;
    }
}

