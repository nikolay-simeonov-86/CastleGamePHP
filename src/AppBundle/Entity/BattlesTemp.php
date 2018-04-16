<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BattlesTemp
 *
 * @ORM\Table(name="battles_temp")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BattlesTempRepository")
 */
class BattlesTemp
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
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="attacker", referencedColumnName="id")
     */
    private $attacker;

    /**
     * @var string
     *
     * @ORM\Column(name="defender", type="string", length=255)
     */
    private $defender;

    /**
     * @var int
     *
     * @ORM\Column(name="footmen_lvl1", type="integer")
     */
    private $footmenLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="footmen_lvl2", type="integer")
     */
    private $footmenLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="footmen_lvl3", type="integer")
     */
    private $footmenLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="archers_lvl1", type="integer")
     */
    private $archersLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="archers_lvl2", type="integer")
     */
    private $archersLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="archers_lvl3", type="integer")
     */
    private $archersLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="cavalry_lvl1", type="integer")
     */
    private $cavalryLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="cavalry_lvl2", type="integer")
     */
    private $cavalryLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="cavalry_lvl3", type="integer")
     */
    private $cavalryLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="reach_time", type="integer")
     */
    private $reachTime;

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
     * Set attacker
     *
     * @param User $attacker
     */
    public function setAttacker(User $attacker)
    {
        $this->attacker = $attacker;
    }

    /**
     * Get attacker
     *
     * @return User
     */
    public function getAttacker()
    {
        return $this->attacker;
    }

    /**
     * @return string
     */
    public function getDefender(): string
    {
        return $this->defender;
    }

    /**
     * @param string $defender
     */
    public function setDefender(string $defender)
    {
        $this->defender = $defender;
    }

    /**
     * @return int
     */
    public function getFootmenLvl1(): int
    {
        return $this->footmenLvl1;
    }

    /**
     * @param int $footmenLvl1
     */
    public function setFootmenLvl1(int $footmenLvl1)
    {
        $this->footmenLvl1 = $footmenLvl1;
    }

    /**
     * @return int
     */
    public function getFootmenLvl2(): int
    {
        return $this->footmenLvl2;
    }

    /**
     * @param int $footmenLvl2
     */
    public function setFootmenLvl2(int $footmenLvl2)
    {
        $this->footmenLvl2 = $footmenLvl2;
    }

    /**
     * @return int
     */
    public function getFootmenLvl3(): int
    {
        return $this->footmenLvl3;
    }

    /**
     * @param int $footmenLvl3
     */
    public function setFootmenLvl3(int $footmenLvl3)
    {
        $this->footmenLvl3 = $footmenLvl3;
    }

    /**
     * @return int
     */
    public function getArchersLvl1(): int
    {
        return $this->archersLvl1;
    }

    /**
     * @param int $archersLvl1
     */
    public function setArchersLvl1(int $archersLvl1)
    {
        $this->archersLvl1 = $archersLvl1;
    }

    /**
     * @return int
     */
    public function getArchersLvl2(): int
    {
        return $this->archersLvl2;
    }

    /**
     * @param int $archersLvl2
     */
    public function setArchersLvl2(int $archersLvl2)
    {
        $this->archersLvl2 = $archersLvl2;
    }

    /**
     * @return int
     */
    public function getArchersLvl3(): int
    {
        return $this->archersLvl3;
    }

    /**
     * @param int $archersLvl3
     */
    public function setArchersLvl3(int $archersLvl3)
    {
        $this->archersLvl3 = $archersLvl3;
    }

    /**
     * @return int
     */
    public function getCavalryLvl1(): int
    {
        return $this->cavalryLvl1;
    }

    /**
     * @param int $cavalryLvl1
     */
    public function setCavalryLvl1(int $cavalryLvl1)
    {
        $this->cavalryLvl1 = $cavalryLvl1;
    }

    /**
     * @return int
     */
    public function getCavalryLvl2(): int
    {
        return $this->cavalryLvl2;
    }

    /**
     * @param int $cavalryLvl2
     */
    public function setCavalryLvl2(int $cavalryLvl2)
    {
        $this->cavalryLvl2 = $cavalryLvl2;
    }

    /**
     * @return int
     */
    public function getCavalryLvl3(): int
    {
        return $this->cavalryLvl3;
    }

    /**
     * @param int $cavalryLvl3
     */
    public function setCavalryLvl3(int $cavalryLvl3)
    {
        $this->cavalryLvl3 = $cavalryLvl3;
    }

    /**
     * Set reachTime.
     *
     * @param int $reachTime
     *
     * @return BattlesTemp
     */
    public function setReachTime($reachTime)
    {
        $this->reachTime = $reachTime;

        return $this;
    }

    /**
     * Get reachTime.
     *
     * @return int
     */
    public function getReachTime()
    {
        return $this->reachTime;
    }
}