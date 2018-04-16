<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Battles
 *
 * @ORM\Table(name="battles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BattlesRepository")
 */
class Battles
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
     * @ORM\JoinColumn(name="attacker")
     */
    private $attacker;

    /**
     * @var string
     *
     * @ORM\Column(name="defender", type="string", length=255)
     */
    private $defender;

    /**
     * @var ArmyBattles
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArmyBattles", fetch="EAGER")
     * @ORM\JoinColumn(name="footmen_lvl1", nullable=true)
     */
    private $footmenLvl1 = null;

    /**
     * @var ArmyBattles
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArmyBattles", fetch="EAGER")
     * @ORM\JoinColumn(name="footmen_lvl2", nullable=true)
     */
    private $footmenLvl2 = null;

    /**
     * @var ArmyBattles
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArmyBattles", fetch="EAGER")
     * @ORM\JoinColumn(name="footmen_lvl3", nullable=true)
     */
    private $footmenLvl3 = null;

    /**
     * @var ArmyBattles
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArmyBattles", fetch="EAGER")
     * @ORM\JoinColumn(name="archers_lvl1", nullable=true)
     */
    private $archersLvl1 = null;

    /**
     * @var ArmyBattles
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArmyBattles", fetch="EAGER")
     * @ORM\JoinColumn(name="archers_lvl2", nullable=true)
     */
    private $archersLvl2 = null;

    /**
     * @var ArmyBattles
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArmyBattles", fetch="EAGER")
     * @ORM\JoinColumn(name="archers_lvl3", nullable=true)
     */
    private $archersLvl3 = null;

    /**
     * @var ArmyBattles
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArmyBattles", fetch="EAGER")
     * @ORM\JoinColumn(name="cavalry_lvl1", nullable=true)
     */
    private $cavalryLvl1 = null;

    /**
     * @var ArmyBattles
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArmyBattles", fetch="EAGER")
     * @ORM\JoinColumn(name="cavalry_lvl2", nullable=true)
     */
    private $cavalryLvl2 = null;

    /**
     * @var ArmyBattles
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArmyBattles", fetch="EAGER")
     * @ORM\JoinColumn(name="cavalry_lvl3", nullable=true)
     */
    private $cavalryLvl3 = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reach_date", type="datetime")
     */
    private $reachDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="return_date", type="datetime")
     */
    private $returnDate;

    /**
     * @var int
     *
     * @ORM\Column(name="castleId", type="integer")
     */
    private $castleId;

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
     * Set footmenLvl1
     *
     * @param ArmyBattles $footmenLvl1
     */
    public function setFootmenLvl1(ArmyBattles $footmenLvl1)
    {
        $this->footmenLvl1 = $footmenLvl1;
    }

    /**
     * Get footmenLvl1
     *
     * @return ArmyBattles
     */
    public function getFootmenLvl1()
    {
        return $this->footmenLvl1;
    }

    /**
     * Set footmenLvl2
     *
     * @param ArmyBattles $footmenLvl2
     */
    public function setFootmenLvl2(ArmyBattles $footmenLvl2)
    {
        $this->footmenLvl2 = $footmenLvl2;
    }

    /**
     * Get footmenLvl2
     *
     * @return ArmyBattles
     */
    public function getFootmenLvl2()
    {
        return $this->footmenLvl2;
    }

    /**
     * Set footmenLvl3
     *
     * @param ArmyBattles $footmenLvl3
     */
    public function setFootmenLvl3(ArmyBattles $footmenLvl3)
    {
        $this->footmenLvl3 = $footmenLvl3;
    }

    /**
     * Get footmenLvl3
     *
     * @return ArmyBattles
     */
    public function getFootmenLvl3()
    {
        return $this->footmenLvl3;
    }

    /**
     * Set archersLvl1
     *
     * @param ArmyBattles $archersLvl1
     */
    public function setArchersLvl1(ArmyBattles $archersLvl1)
    {
        $this->archersLvl1 = $archersLvl1;
    }

    /**
     * Get archersLvl1
     *
     * @return ArmyBattles
     */
    public function getArchersLvl1()
    {
        return $this->archersLvl1;
    }

    /**
     * Set archersLvl2
     *
     * @param ArmyBattles $archersLvl2
     */
    public function setArchersLvl2(ArmyBattles $archersLvl2)
    {
        $this->archersLvl2 = $archersLvl2;
    }

    /**
     * Get archersLvl2
     *
     * @return ArmyBattles
     */
    public function getArchersLvl2()
    {
        return $this->archersLvl2;
    }

    /**
     * Set archersLvl3
     *
     * @param ArmyBattles $archersLvl3
     */
    public function setArchersLvl3(ArmyBattles $archersLvl3)
    {
        $this->archersLvl3 = $archersLvl3;
    }

    /**
     * Get archersLvl3
     *
     * @return ArmyBattles
     */
    public function getArchersLvl3()
    {
        return $this->archersLvl3;
    }

    /**
     * Set cavalryLvl1
     *
     * @param ArmyBattles $cavalryLvl1
     */
    public function setCavalryLvl1(ArmyBattles $cavalryLvl1)
    {
        $this->cavalryLvl1 = $cavalryLvl1;
    }

    /**
     * Get cavalryLvl1
     *
     * @return ArmyBattles
     */
    public function getCavalryLvl1()
    {
        return $this->cavalryLvl1;
    }

    /**
     * Set cavalryLvl2
     *
     * @param ArmyBattles $cavalryLvl2
     */
    public function setCavalryLvl2(ArmyBattles $cavalryLvl2)
    {
        $this->cavalryLvl2 = $cavalryLvl2;
    }

    /**
     * Get cavalryLvl2
     *
     * @return ArmyBattles
     */
    public function getCavalryLvl2()
    {
        return $this->cavalryLvl2;
    }

    /**
     * Set cavalryLvl3
     *
     * @param ArmyBattles $cavalryLvl3
     */
    public function setCavalryLvl3(ArmyBattles $cavalryLvl3)
    {
        $this->cavalryLvl3 = $cavalryLvl3;
    }

    /**
     * Get cavalryLvl3
     *
     * @return ArmyBattles
     */
    public function getCavalryLvl3()
    {
        return $this->cavalryLvl3;
    }

    /**
     * Set reachDate.
     *
     * @param \DateTime $reachDate
     *
     * @return Battles
     */
    public function setReachDate($reachDate)
    {
        $this->reachDate = $reachDate;

        return $this;
    }

    /**
     * Get reachDate.
     *
     * @return \DateTime
     */
    public function getReachDate()
    {
        return $this->reachDate;
    }

    /**
     * @return \DateTime
     */
    public function getReturnDate(): \DateTime
    {
        return $this->returnDate;
    }

    /**
     * @param \DateTime $returnDate
     */
    public function setReturnDate(\DateTime $returnDate)
    {
        $this->returnDate = $returnDate;
    }

    /**
     * @return int
     */
    public function getCastleId(): int
    {
        return $this->castleId;
    }

    /**
     * @param int $castleId
     */
    public function setCastleId(int $castleId): void
    {
        $this->castleId = $castleId;
    }
}
