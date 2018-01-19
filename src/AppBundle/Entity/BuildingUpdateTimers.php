<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BuildingUpdateTimers
 *
 * @ORM\Table(name="building_update_timers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BuildingUpdateTimersRepository")
 */
class BuildingUpdateTimers
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
     * @ORM\Column(name="building", type="string", length=255)
     */
    private $building;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finish_time", type="datetime")
     */
    private $finishTime;

    /**
     * @var int
     *
     * @ORM\Column(name="upgrade_to_lvl", type="integer")
     */
    private $upgradeToLvl;

    /**
     * @var Castle
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Castle", inversedBy="buildingUpdateTimers")
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
     * Set building
     *
     * @param string $building
     *
     * @return BuildingUpdateTimers
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return string
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set finishTime
     *
     * @param \DateTime $finishTime
     *
     * @return BuildingUpdateTimers
     */
    public function setFinishTime($finishTime)
    {
        $this->finishTime = $finishTime;

        return $this;
    }

    /**
     * Get finishTime
     *
     * @return \DateTime
     */
    public function getFinishTime()
    {
        return $this->finishTime;
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
     * @return int
     */
    public function getUpgradeToLvl()
    {
        return $this->upgradeToLvl;
    }

    /**
     * @param int $upgradeToLvl
     */
    public function setUpgradeToLvl($upgradeToLvl)
    {
        $this->upgradeToLvl = $upgradeToLvl;
    }
}

