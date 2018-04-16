<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * Army
 *
 * @ORM\Table(name="army")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArmyRepository")
 */
class Army
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="smallint")
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(name="health", type="integer")
     */
    private $health;

    /**
     * @var int
     *
     * @ORM\Column(name="damage", type="integer")
     */
    private $damage;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="bonus_damage", type="integer")
     */
    private $bonusDamage;

    /**
     * @var string
     *
     * @ORM\Column(name="bonus_versus", type="string", length=255)
     */
    private $bonusVersus;

    /**
     * @var string
     *
     * @ORM\Column(name="army_picture", type="string")
     */
    private $armyPicture;

    /**
     * @var Castle
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Castle", inversedBy="army")
     * @ORM\JoinColumn(name="castle_id")
     */
    private $castleId;

    /**
     * @var ArmyTrainTimers[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ArmyTrainTimers", mappedBy="armyId")
     */
    private $armyTrainTimers;

    /**
     * Army constructor.
     */
    public function __construct()
    {
        $this->armyTrainTimers = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Army
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Army
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set health
     *
     * @param integer $health
     *
     * @return Army
     */
    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * Get health
     *
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Set damage
     *
     * @param integer $damage
     *
     * @return Army
     */
    public function setDamage($damage)
    {
        $this->damage = $damage;

        return $this;
    }

    /**
     * Get damage
     *
     * @return int
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * Set bonusDamage
     *
     * @param integer $bonusDamage
     *
     * @return Army
     */
    public function setBonusDamage($bonusDamage)
    {
        $this->bonusDamage = $bonusDamage;

        return $this;
    }

    /**
     * Get bonusDamage
     *
     * @return int
     */
    public function getBonusDamage()
    {
        return $this->bonusDamage;
    }

    /**
     * Set bonusVersus.
     *
     * @param string $bonusVersus
     *
     * @return Army
     */
    public function setBonusVersus($bonusVersus)
    {
        $this->bonusVersus = $bonusVersus;

        return $this;
    }

    /**
     * Get bonusVersus.
     *
     * @return string
     */
    public function getBonusVersus()
    {
        return $this->bonusVersus;
    }

    /**
     * Get armyPicture
     *
     * @return string
     */
    public function getArmyPicture(): string
    {
        return $this->armyPicture;
    }

    /**
     * Set armyPicture
     *
     * @param string $armyPicture
     *
     * @return Army
     */
    public function setArmyPicture(string $armyPicture)
    {
        $this->armyPicture = $armyPicture;

        return $this;
    }

    /**
     * Set castleId
     *
     * @param Castle $castleId
     */
    public function setCastleId(Castle $castleId)
    {
        $this->castleId = $castleId;
    }

    /**
     * Get castleId
     *
     * @return Castle
     */
    public function getCastleId()
    {
        return $this->castleId;
    }

    /**
     * Set armyTrainTimers
     *
     * @param ArmyTrainTimers[] $armyTrainTimers
     */
    public function setArmyTrainTimers(array $armyTrainTimers)
    {
        $this->armyTrainTimers = $armyTrainTimers;
    }

    /**
     * Get armyTrainTimers
     *
     * @return Collection|ArmyTrainTimers[]
     */
    public function getArmyTrainTimers()
    {
        return $this->armyTrainTimers;
    }
}

