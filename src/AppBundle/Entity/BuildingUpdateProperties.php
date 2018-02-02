<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BuildingUpdateProperties
 *
 * @ORM\Table(name="building_update_properties")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BuildingUpdatePropertiesRepository")
 */
class BuildingUpdateProperties
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
     * @ORM\Column(name="level1_food", type="integer")
     */
    private $level1Food;

    /**
     * @var int
     *
     * @ORM\Column(name="level1_metal", type="integer")
     */
    private $level1Metal;

    /**
     * @var int
     *
     * @ORM\Column(name="level1_timer", type="integer")
     */
    private $level1Timer;

    /**
     * @var int
     *
     * @ORM\Column(name="level2_food", type="integer")
     */
    private $level2Food;

    /**
     * @var int
     *
     * @ORM\Column(name="level2_metal", type="integer")
     */
    private $level2Metal;

    /**
     * @var int
     *
     * @ORM\Column(name="level2_timer", type="integer")
     */
    private $level2Timer;

    /**
     * @var int
     *
     * @ORM\Column(name="level3_food", type="integer")
     */
    private $level3Food;

    /**
     * @var int
     *
     * @ORM\Column(name="level3_metal", type="integer")
     */
    private $level3Metal;

    /**
     * @var int
     *
     * @ORM\Column(name="level3_timer", type="integer")
     */
    private $level3Timer;


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
     * @return BuildingUpdateProperties
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
     * Set level1Food.
     *
     * @param int $level1Food
     *
     * @return BuildingUpdateProperties
     */
    public function setLevel1Food($level1Food)
    {
        $this->level1Food = $level1Food;

        return $this;
    }

    /**
     * Get level1Food.
     *
     * @return int
     */
    public function getLevel1Food()
    {
        return $this->level1Food;
    }

    /**
     * Set level1Metal.
     *
     * @param int $level1Metal
     *
     * @return BuildingUpdateProperties
     */
    public function setLevel1Metal($level1Metal)
    {
        $this->level1Metal = $level1Metal;

        return $this;
    }

    /**
     * Get level1Metal.
     *
     * @return int
     */
    public function getLevel1Metal()
    {
        return $this->level1Metal;
    }

    /**
     * Set level2Food.
     *
     * @param int $level2Food
     *
     * @return BuildingUpdateProperties
     */
    public function setLevel2Food($level2Food)
    {
        $this->level2Food = $level2Food;

        return $this;
    }

    /**
     * Get level2Food.
     *
     * @return int
     */
    public function getLevel2Food()
    {
        return $this->level2Food;
    }

    /**
     * Set level2Metal.
     *
     * @param int $level2Metal
     *
     * @return BuildingUpdateProperties
     */
    public function setLevel2Metal($level2Metal)
    {
        $this->level2Metal = $level2Metal;

        return $this;
    }

    /**
     * Get level2Metal.
     *
     * @return int
     */
    public function getLevel2Metal()
    {
        return $this->level2Metal;
    }

    /**
     * Set level3Food.
     *
     * @param int $level3Food
     *
     * @return BuildingUpdateProperties
     */
    public function setLevel3Food($level3Food)
    {
        $this->level3Food = $level3Food;

        return $this;
    }

    /**
     * Get level3Food.
     *
     * @return int
     */
    public function getLevel3Food()
    {
        return $this->level3Food;
    }

    /**
     * Set level3Metal.
     *
     * @param int $level3Metal
     *
     * @return BuildingUpdateProperties
     */
    public function setLevel3Metal($level3Metal)
    {
        $this->level3Metal = $level3Metal;

        return $this;
    }

    /**
     * Get level3Metal.
     *
     * @return int
     */
    public function getLevel3Metal()
    {
        return $this->level3Metal;
    }

    /**
     * @return int
     */
    public function getLevel1Timer(): int
    {
        return $this->level1Timer;
    }

    /**
     * @param int $level1Timer
     */
    public function setLevel1Timer(int $level1Timer)
    {
        $this->level1Timer = $level1Timer;
    }

    /**
     * @return int
     */
    public function getLevel2Timer(): int
    {
        return $this->level2Timer;
    }

    /**
     * @param int $level2Timer
     */
    public function setLevel2Timer(int $level2Timer)
    {
        $this->level2Timer = $level2Timer;
    }

    /**
     * @return int
     */
    public function getLevel3Timer(): int
    {
        return $this->level3Timer;
    }

    /**
     * @param int $level3Timer
     */
    public function setLevel3Timer(int $level3Timer)
    {
        $this->level3Timer = $level3Timer;
    }
}
