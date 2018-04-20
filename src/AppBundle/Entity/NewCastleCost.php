<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewCastleCost
 *
 * @ORM\Table(name="new_castle_cost")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NewCastleCostRepository")
 */
class NewCastleCost
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
     * @var int
     *
     * @ORM\Column(name="food_cost", type="integer")
     */
    private $foodCost;

    /**
     * @var int
     *
     * @ORM\Column(name="metal_cost", type="integer")
     */
    private $metalCost;


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
     * Set foodCost.
     *
     * @param int $foodCost
     *
     * @return NewCastleCost
     */
    public function setFoodCost($foodCost)
    {
        $this->foodCost = $foodCost;

        return $this;
    }

    /**
     * Get foodCost.
     *
     * @return int
     */
    public function getFoodCost()
    {
        return $this->foodCost;
    }

    /**
     * Set metalCost.
     *
     * @param int $metalCost
     *
     * @return NewCastleCost
     */
    public function setMetalCost($metalCost)
    {
        $this->metalCost = $metalCost;

        return $this;
    }

    /**
     * Get metalCost.
     *
     * @return int
     */
    public function getMetalCost()
    {
        return $this->metalCost;
    }
}
