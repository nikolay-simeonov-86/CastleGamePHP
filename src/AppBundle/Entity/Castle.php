<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Castle
 *
 * @ORM\Table(name="castles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CastleRepository")
 */
class Castle
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
     * @var string
     *
     * @ORM\Column(name="castle_icon", type="string", length=255)
     */
    private $castleIcon;

    /**
     * @var int
     *
     * @ORM\Column(name="army_lvl1_count", type="integer")
     */
    private $armyLvl1Count;

    /**
     * @var int
     *
     * @ORM\Column(name="army_lvl2_count", type="integer")
     */
    private $armyLvl2Count;

    /**
     * @var int
     *
     * @ORM\Column(name="army_lvl3_count", type="integer")
     */
    private $armyLvl3Count;

    /**
     * @var int
     *
     * @ORM\Column(name="army_lvl1_building", type="smallint")
     */
    private $armyLvl1Building;

    /**
     * @var int
     *
     * @ORM\Column(name="army_lvl2_building", type="smallint")
     */
    private $armyLvl2Building;

    /**
     * @var int
     *
     * @ORM\Column(name="army_lvl3_building", type="smallint")
     */
    private $armyLvl3Building;

    /**
     * @var int
     *
     * @ORM\Column(name="castle_lvl", type="smallint")
     */
    private $castleLvl;

    /**
     * @var int
     *
     * @ORM\Column(name="mine_food_lvl", type="smallint")
     */
    private $mineFoodLvl;

    /**
     * @var int
     *
     * @ORM\Column(name="mine_metal_lvl", type="smallint")
     */
    private $mineMetalLvl;

    /**
     * @var int
     *
     * @ORM\Column(name="resource_food", type="integer")
     */
    private $resourceFood;

    /**
     * @var int
     *
     * @ORM\Column(name="resource_metal", type="integer")
     */
    private $resourceMetal;

    /**
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="castles")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * Castle constructor
     */
    public function __construct()
    {
        $this->armyLvl1Count = 0;
        $this->armyLvl2Count = 0;
        $this->armyLvl3Count = 0;
        $this->armyLvl1Building = 1;
        $this->armyLvl2Building = 0;
        $this->armyLvl3Building = 0;
        $this->castleLvl = 1;
        $this->mineFoodLvl = 1;
        $this->mineMetalLvl = 0;
        $this->resourceFood = 50;
        $this->resourceMetal = 0;
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
     * @return Castle
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
     * Set armyLvl1Count
     *
     * @param integer $armyLvl1Count
     *
     * @return Castle
     */
    public function setArmyLvl1Count($armyLvl1Count)
    {
        $this->armyLvl1Count = $armyLvl1Count;

        return $this;
    }

    /**
     * Get armyLvl1Count
     *
     * @return int
     */
    public function getArmyLvl1Count()
    {
        return $this->armyLvl1Count;
    }

    /**
     * Set armyLvl2Count
     *
     * @param integer $armyLvl2Count
     *
     * @return Castle
     */
    public function setArmyLvl2Count($armyLvl2Count)
    {
        $this->armyLvl2Count = $armyLvl2Count;

        return $this;
    }

    /**
     * Get armyLvl2Count
     *
     * @return int
     */
    public function getArmyLvl2Count()
    {
        return $this->armyLvl2Count;
    }

    /**
     * Set armyLvl3Count
     *
     * @param integer $armyLvl3Count
     *
     * @return Castle
     */
    public function setArmyLvl3Count($armyLvl3Count)
    {
        $this->armyLvl3Count = $armyLvl3Count;

        return $this;
    }

    /**
     * Get armyLvl3Count
     *
     * @return int
     */
    public function getArmyLvl3Count()
    {
        return $this->armyLvl3Count;
    }

    /**
     * Set armyLvl1Building
     *
     * @param integer $armyLvl1Building
     *
     * @return Castle
     */
    public function setArmyLvl1Building($armyLvl1Building)
    {
        $this->armyLvl1Building = $armyLvl1Building;

        return $this;
    }

    /**
     * Get armyLvl1Building
     *
     * @return int
     */
    public function getArmyLvl1Building()
    {
        return $this->armyLvl1Building;
    }

    /**
     * Set armyLvl2Building
     *
     * @param integer $armyLvl2Building
     *
     * @return Castle
     */
    public function setArmyLvl2Building($armyLvl2Building)
    {
        $this->armyLvl2Building = $armyLvl2Building;

        return $this;
    }

    /**
     * Get armyLvl2Building
     *
     * @return int
     */
    public function getArmyLvl2Building()
    {
        return $this->armyLvl2Building;
    }

    /**
     * Set armyLvl3Building
     *
     * @param integer $armyLvl3Building
     *
     * @return Castle
     */
    public function setArmyLvl3Building($armyLvl3Building)
    {
        $this->armyLvl3Building = $armyLvl3Building;

        return $this;
    }

    /**
     * Get armyLvl3Building
     *
     * @return int
     */
    public function getArmyLvl3Building()
    {
        return $this->armyLvl3Building;
    }

    /**
     * Set castleLvl
     *
     * @param integer $castleLvl
     *
     * @return Castle
     */
    public function setCastleLvl($castleLvl)
    {
        $this->castleLvl = $castleLvl;

        return $this;
    }

    /**
     * Get castleLvl
     *
     * @return int
     */
    public function getCastleLvl()
    {
        return $this->castleLvl;
    }

    /**
     * Set mineFoodLvl
     *
     * @param integer $mineFoodLvl
     *
     * @return Castle
     */
    public function setMineFoodLvl($mineFoodLvl)
    {
        $this->mineFoodLvl = $mineFoodLvl;

        return $this;
    }

    /**
     * Get mineFoodLvl
     *
     * @return int
     */
    public function getMineFoodLvl()
    {
        return $this->mineFoodLvl;
    }

    /**
     * Set mineMetalLvl
     *
     * @param integer $mineMetalLvl
     *
     * @return Castle
     */
    public function setMineMetalLvl($mineMetalLvl)
    {
        $this->mineMetalLvl = $mineMetalLvl;

        return $this;
    }

    /**
     * Get mineMetalLvl
     *
     * @return int
     */
    public function getMineMetalLvl()
    {
        return $this->mineMetalLvl;
    }

    /**
     * Set resourceFood
     *
     * @param integer $resourceFood
     *
     * @return Castle
     */
    public function setResourceFood($resourceFood)
    {
        $this->resourceFood = $resourceFood;

        return $this;
    }

    /**
     * Get resourceFood
     *
     * @return int
     */
    public function getResourceFood()
    {
        return $this->resourceFood;
    }

    /**
     * Set resourceMetal
     *
     * @param integer $resourceMetal
     *
     * @return Castle
     */
    public function setResourceMetal($resourceMetal)
    {
        $this->resourceMetal = $resourceMetal;

        return $this;
    }

    /**
     * Get resourceMetal
     *
     * @return int
     */
    public function getResourceMetal()
    {
        return $this->resourceMetal;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Castle
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}

