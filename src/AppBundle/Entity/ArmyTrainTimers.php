<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArmyTrainTimers
 *
 * @ORM\Table(name="army_train_timers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArmyTrainTimersRepository")
 */
class ArmyTrainTimers
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
     * @ORM\Column(name="army_type", type="string", length=255)
     */
    private $armyType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="finish_time", type="datetime")
     */
    private $finishTime;

    /**
     * @var int
     *
     * @ORM\Column(name="train_amount", type="integer")
     */
    private $trainAmount;

    /**
     * @var Army
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Army", inversedBy="armyTrainTimers")
     * @ORM\JoinColumn(name="army_id")
     */
    private $armyId;

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
     * Set armyType
     *
     * @param string $armyType
     *
     * @return ArmyTrainTimers
     */
    public function setArmyType($armyType)
    {
        $this->armyType = $armyType;

        return $this;
    }

    /**
     * Get armyType
     *
     * @return string
     */
    public function getArmyType()
    {
        return $this->armyType;
    }

    /**
     * Set finishTime
     *
     * @param \DateTime $finishTime
     *
     * @return ArmyTrainTimers
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
     * Set trainAmount
     *
     * @param integer $trainAmount
     *
     * @return ArmyTrainTimers
     */
    public function setTrainAmount($trainAmount)
    {
        $this->trainAmount = $trainAmount;

        return $this;
    }

    /**
     * Get trainAmount
     *
     * @return int
     */
    public function getTrainAmount()
    {
        return $this->trainAmount;
    }

    /**
     * Set armyId
     *
     * @param Army $armyId
     */
    public function setCastleId(Army $armyId)
    {
        $this->armyId = $armyId;
    }

    /**
     * Get armyId
     *
     * @return Army
     */
    public function getArmyId()
    {
        return $this->armyId;
    }
}

