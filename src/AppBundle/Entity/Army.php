<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="hp", type="integer")
     */
    private $hp;

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
     * Set hp
     *
     * @param integer $hp
     *
     * @return Army
     */
    public function setHp($hp)
    {
        $this->hp = $hp;

        return $this;
    }

    /**
     * Get hp
     *
     * @return int
     */
    public function getHp()
    {
        return $this->hp;
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
     * Set costFood
     *
     * @param integer $costFood
     *
     * @return Army
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
     * @return Army
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
}

