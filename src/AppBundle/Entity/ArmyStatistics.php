<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArmyStatistics
 *
 * @ORM\Table(name="army_statistics")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArmyStatisticsRepository")
 */
class ArmyStatistics
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
     * @ORM\Column(name="cost_food", type="integer")
     */
    private $costFood;

    /**
     * @var int
     *
     * @ORM\Column(name="cost_metal", type="integer")
     */
    private $costMetal;

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
     * @var int
     *
     * @ORM\Column(name="train_time", type="integer")
     */
    private $trainTime;


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
     * @return ArmyStatistics
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
     * @return ArmyStatistics
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
     * @return ArmyStatistics
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
     * @return ArmyStatistics
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
     * Set costFood
     *
     * @param integer $costFood
     *
     * @return ArmyStatistics
     */
    public function setCostFood($costFood)
    {
        $this->costFood = $costFood;

        return $this;
    }

    /**
     * Get costFood
     *
     * @return int
     */
    public function getCostFood()
    {
        return $this->costFood;
    }

    /**
     * Set costMetal
     *
     * @param integer $costMetal
     *
     * @return ArmyStatistics
     */
    public function setCostMetal($costMetal)
    {
        $this->costMetal = $costMetal;

        return $this;
    }

    /**
     * Get costMetal
     *
     * @return int
     */
    public function getCostMetal()
    {
        return $this->costMetal;
    }

    /**
     * Set bonusDamage
     *
     * @param integer $bonusDamage
     *
     * @return ArmyStatistics
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
     * @return ArmyStatistics
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
     * @return int
     */
    public function getTrainTime()
    {
        return $this->trainTime;
    }

    /**
     * @param int $trainTime
     */
    public function setTrainTime($trainTime)
    {
        $this->trainTime = $trainTime;
    }
}

