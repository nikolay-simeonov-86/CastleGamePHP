<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArmyBattles
 *
 * @ORM\Table(name="army_battles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArmyBattleRepository")
 */
class ArmyBattles
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
     * @ORM\Column(name="level", type="integer")
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
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="armyBattles")
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
     * Set name.
     *
     * @param string $name
     *
     * @return ArmyBattles
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set level.
     *
     * @param int $level
     *
     * @return ArmyBattles
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level.
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set health.
     *
     * @param int $health
     *
     * @return ArmyBattles
     */
    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    /**
     * Get health.
     *
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Set damage.
     *
     * @param int $damage
     *
     * @return ArmyBattles
     */
    public function setDamage($damage)
    {
        $this->damage = $damage;

        return $this;
    }

    /**
     * Get damage.
     *
     * @return int
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * Set amount.
     *
     * @param int $amount
     *
     * @return ArmyBattles
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set bonusDamage.
     *
     * @param int $bonusDamage
     *
     * @return ArmyBattles
     */
    public function setBonusDamage($bonusDamage)
    {
        $this->bonusDamage = $bonusDamage;

        return $this;
    }

    /**
     * Get bonusDamage.
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
     * @return ArmyBattles
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
     * @return ArmyBattles
     */
    public function setArmyPicture(string $armyPicture)
    {
        $this->armyPicture = $armyPicture;

        return $this;
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
