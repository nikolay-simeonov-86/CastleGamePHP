<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BattleReports
 *
 * @ORM\Table(name="battle_reports")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BattleReportsRepository")
 */
class BattleReports
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
     * @ORM\Column(name="attacker", type="string", length=255)
     */
    private $attacker;

    /**
     * @var string
     *
     * @ORM\Column(name="defender", type="string", length=255)
     */
    private $defender;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_remaining_footmen_lvl1", type="integer")
     */
    private $attackerRemainingFootmenLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_remaining_footmen_lvl2", type="integer")
     */
    private $attackerRemainingFootmenLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_remaining_footmen_lvl3", type="integer")
     */
    private $attackerRemainingFootmenLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_remaining_archers_lvl1", type="integer")
     */
    private $attackerRemainingArchersLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_remaining_archers_lvl2", type="integer")
     */
    private $attackerRemainingArchersLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_remaining_archers_lvl3", type="integer")
     */
    private $attackerRemainingArchersLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_remaining_cavalry_lvl1", type="integer")
     */
    private $attackerRemainingCavalryLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_remaining_cavalry_lvl2", type="integer")
     */
    private $attackerRemainingCavalryLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_remaining_cavalry_lvl3", type="integer")
     */
    private $attackerRemainingCavalryLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_dead_footmen_lvl1", type="integer")
     */
    private $attackerDeadFootmenLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_dead_footmen_lvl2", type="integer")
     */
    private $attackerDeadFootmenLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_dead_footmen_lvl3", type="integer")
     */
    private $attackerDeadFootmenLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_dead_archers_lvl1", type="integer")
     */
    private $attackerDeadArchersLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_dead_archers_lvl2", type="integer")
     */
    private $attackerDeadArchersLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_dead_archers_lvl3", type="integer")
     */
    private $attackerDeadArchersLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_dead_cavalry_lvl1", type="integer")
     */
    private $attackerDeadCavalryLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_dead_cavalry_lvl2", type="integer")
     */
    private $attackerDeadCavalryLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="attacker_dead_cavalry_lvl3", type="integer")
     */
    private $attackerDeadCavalryLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_remaining_footmen_lvl1", type="integer")
     */
    private $defenderRemainingFootmenLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_remaining_footmen_lvl2", type="integer")
     */
    private $defenderRemainingFootmenLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_remaining_footmen_lvl3", type="integer")
     */
    private $defenderRemainingFootmenLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_remaining_archers_lvl1", type="integer")
     */
    private $defenderRemainingArchersLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_remaining_archers_lvl2", type="integer")
     */
    private $defenderRemainingArchersLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_remaining_archers_lvl3", type="integer")
     */
    private $defenderRemainingArchersLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_remaining_cavalry_lvl1", type="integer")
     */
    private $defenderRemainingCavalryLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_remaining_cavalry_lvl2", type="integer")
     */
    private $defenderRemainingCavalryLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_remaining_cavalry_lvl3", type="integer")
     */
    private $defenderRemainingCavalryLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_dead_footmen_lvl1", type="integer")
     */
    private $defenderDeadFootmenLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_dead_footmen_lvl2", type="integer")
     */
    private $defenderDeadFootmenLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_dead_footmen_lvl3", type="integer")
     */
    private $defenderDeadFootmenLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_dead_archers_lvl1", type="integer")
     */
    private $defenderDeadArchersLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_dead_archers_lvl2", type="integer")
     */
    private $defenderDeadArchersLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_dead_archers_lvl3", type="integer")
     */
    private $defenderDeadArchersLvl3;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_dead_cavalry_lvl1", type="integer")
     */
    private $defenderDeadCavalryLvl1;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_dead_cavalry_lvl2", type="integer")
     */
    private $defenderDeadCavalryLvl2;

    /**
     * @var int
     *
     * @ORM\Column(name="defender_dead_cavalry_lvl3", type="integer")
     */
    private $defenderDeadCavalryLvl3;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="battle_date", type="datetime")
     */
    private $battleDate;

    /**
     * @var string
     *
     * @ORM\Column(name="winner", type="string", length=255)
     */
    private $winner;

    /**
     * @var int
     *
     * @ORM\Column(name="gained_food", type="integer")
     */
    private $gainedFood;

    /**
     * @var int
     *
     * @ORM\Column(name="gained_metal", type="integer")
     */
    private $gainedMetal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="return_date", type="datetime")
     */
    private $returnDate;

    /**
     * @var int
     *
     * @ORM\Column(name="castle_id", type="integer")
     */
    private $castleId;

    /**
     * @var bool
     *
     * @ORM\Column(name="army_returned_to_castle", type="boolean")
     */
    private $armyReturnedToCastle;

    /**
     * @var bool
     *
     * @ORM\Column(name="visited", type="boolean")
     */
    private $visited;

    /**
     * BattleReports constructor.
     */
    public function __construct()
    {
        $this->attackerRemainingFootmenLvl1 = 0;
        $this->attackerRemainingFootmenLvl2 = 0;
        $this->attackerRemainingFootmenLvl3 = 0;
        $this->attackerRemainingArchersLvl1 = 0;
        $this->attackerRemainingArchersLvl2 = 0;
        $this->attackerRemainingArchersLvl3 = 0;
        $this->attackerRemainingCavalryLvl1 = 0;
        $this->attackerRemainingCavalryLvl2 = 0;
        $this->attackerRemainingCavalryLvl3 = 0;
        $this->attackerDeadFootmenLvl1 = 0;
        $this->attackerDeadFootmenLvl2 = 0;
        $this->attackerDeadFootmenLvl3 = 0;
        $this->attackerDeadArchersLvl1 = 0;
        $this->attackerDeadArchersLvl2 = 0;
        $this->attackerDeadArchersLvl3 = 0;
        $this->attackerDeadCavalryLvl1 = 0;
        $this->attackerDeadCavalryLvl2 = 0;
        $this->attackerDeadCavalryLvl3 = 0;
        $this->defenderRemainingFootmenLvl1 = 0;
        $this->defenderRemainingFootmenLvl2 = 0;
        $this->defenderRemainingFootmenLvl3 = 0;
        $this->defenderRemainingArchersLvl1 = 0;
        $this->defenderRemainingArchersLvl2 = 0;
        $this->defenderRemainingArchersLvl3 = 0;
        $this->defenderRemainingCavalryLvl1 = 0;
        $this->defenderRemainingCavalryLvl2 = 0;
        $this->defenderRemainingCavalryLvl3 = 0;
        $this->defenderDeadFootmenLvl1 = 0;
        $this->defenderDeadFootmenLvl2 = 0;
        $this->defenderDeadFootmenLvl3 = 0;
        $this->defenderDeadArchersLvl1 = 0;
        $this->defenderDeadArchersLvl2 = 0;
        $this->defenderDeadArchersLvl3 = 0;
        $this->defenderDeadCavalryLvl1 = 0;
        $this->defenderDeadCavalryLvl2 = 0;
        $this->defenderDeadCavalryLvl3 = 0;
        $this->gainedFood = 0;
        $this->gainedMetal = 0;
        $this->armyReturnedToCastle = false;
        $this->visited = false;
    }

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
     * @return int
     */
    public function getAttackerRemainingFootmenLvl1(): int
    {
        return $this->attackerRemainingFootmenLvl1;
    }

    /**
     * @param int $attackerRemainingFootmenLvl1
     */
    public function setAttackerRemainingFootmenLvl1(int $attackerRemainingFootmenLvl1): void
    {
        $this->attackerRemainingFootmenLvl1 = $attackerRemainingFootmenLvl1;
    }

    /**
     * @return int
     */
    public function getAttackerRemainingFootmenLvl2(): int
    {
        return $this->attackerRemainingFootmenLvl2;
    }

    /**
     * @param int $attackerRemainingFootmenLvl2
     */
    public function setAttackerRemainingFootmenLvl2(int $attackerRemainingFootmenLvl2): void
    {
        $this->attackerRemainingFootmenLvl2 = $attackerRemainingFootmenLvl2;
    }

    /**
     * @return int
     */
    public function getAttackerRemainingFootmenLvl3(): int
    {
        return $this->attackerRemainingFootmenLvl3;
    }

    /**
     * @param int $attackerRemainingFootmenLvl3
     */
    public function setAttackerRemainingFootmenLvl3(int $attackerRemainingFootmenLvl3): void
    {
        $this->attackerRemainingFootmenLvl3 = $attackerRemainingFootmenLvl3;
    }

    /**
     * @return int
     */
    public function getAttackerRemainingArchersLvl1(): int
    {
        return $this->attackerRemainingArchersLvl1;
    }

    /**
     * @param int $attackerRemainingArchersLvl1
     */
    public function setAttackerRemainingArchersLvl1(int $attackerRemainingArchersLvl1): void
    {
        $this->attackerRemainingArchersLvl1 = $attackerRemainingArchersLvl1;
    }

    /**
     * @return int
     */
    public function getAttackerRemainingArchersLvl2(): int
    {
        return $this->attackerRemainingArchersLvl2;
    }

    /**
     * @param int $attackerRemainingArchersLvl2
     */
    public function setAttackerRemainingArchersLvl2(int $attackerRemainingArchersLvl2): void
    {
        $this->attackerRemainingArchersLvl2 = $attackerRemainingArchersLvl2;
    }

    /**
     * @return int
     */
    public function getAttackerRemainingArchersLvl3(): int
    {
        return $this->attackerRemainingArchersLvl3;
    }

    /**
     * @param int $attackerRemainingArchersLvl3
     */
    public function setAttackerRemainingArchersLvl3(int $attackerRemainingArchersLvl3): void
    {
        $this->attackerRemainingArchersLvl3 = $attackerRemainingArchersLvl3;
    }

    /**
     * @return int
     */
    public function getAttackerRemainingCavalryLvl1(): int
    {
        return $this->attackerRemainingCavalryLvl1;
    }

    /**
     * @param int $attackerRemainingCavalryLvl1
     */
    public function setAttackerRemainingCavalryLvl1(int $attackerRemainingCavalryLvl1): void
    {
        $this->attackerRemainingCavalryLvl1 = $attackerRemainingCavalryLvl1;
    }

    /**
     * @return int
     */
    public function getAttackerRemainingCavalryLvl2(): int
    {
        return $this->attackerRemainingCavalryLvl2;
    }

    /**
     * @param int $attackerRemainingCavalryLvl2
     */
    public function setAttackerRemainingCavalryLvl2(int $attackerRemainingCavalryLvl2): void
    {
        $this->attackerRemainingCavalryLvl2 = $attackerRemainingCavalryLvl2;
    }

    /**
     * @return int
     */
    public function getAttackerRemainingCavalryLvl3(): int
    {
        return $this->attackerRemainingCavalryLvl3;
    }

    /**
     * @param int $attackerRemainingCavalryLvl3
     */
    public function setAttackerRemainingCavalryLvl3(int $attackerRemainingCavalryLvl3): void
    {
        $this->attackerRemainingCavalryLvl3 = $attackerRemainingCavalryLvl3;
    }

    /**
     * @return int
     */
    public function getAttackerDeadFootmenLvl1(): int
    {
        return $this->attackerDeadFootmenLvl1;
    }

    /**
     * @param int $attackerDeadFootmenLvl1
     */
    public function setAttackerDeadFootmenLvl1(int $attackerDeadFootmenLvl1): void
    {
        $this->attackerDeadFootmenLvl1 = $attackerDeadFootmenLvl1;
    }

    /**
     * @return int
     */
    public function getAttackerDeadFootmenLvl2(): int
    {
        return $this->attackerDeadFootmenLvl2;
    }

    /**
     * @param int $attackerDeadFootmenLvl2
     */
    public function setAttackerDeadFootmenLvl2(int $attackerDeadFootmenLvl2): void
    {
        $this->attackerDeadFootmenLvl2 = $attackerDeadFootmenLvl2;
    }

    /**
     * @return int
     */
    public function getAttackerDeadFootmenLvl3(): int
    {
        return $this->attackerDeadFootmenLvl3;
    }

    /**
     * @param int $attackerDeadFootmenLvl3
     */
    public function setAttackerDeadFootmenLvl3(int $attackerDeadFootmenLvl3): void
    {
        $this->attackerDeadFootmenLvl3 = $attackerDeadFootmenLvl3;
    }

    /**
     * @return int
     */
    public function getAttackerDeadArchersLvl1(): int
    {
        return $this->attackerDeadArchersLvl1;
    }

    /**
     * @param int $attackerDeadArchersLvl1
     */
    public function setAttackerDeadArchersLvl1(int $attackerDeadArchersLvl1): void
    {
        $this->attackerDeadArchersLvl1 = $attackerDeadArchersLvl1;
    }

    /**
     * @return int
     */
    public function getAttackerDeadArchersLvl2(): int
    {
        return $this->attackerDeadArchersLvl2;
    }

    /**
     * @param int $attackerDeadArchersLvl2
     */
    public function setAttackerDeadArchersLvl2(int $attackerDeadArchersLvl2): void
    {
        $this->attackerDeadArchersLvl2 = $attackerDeadArchersLvl2;
    }

    /**
     * @return int
     */
    public function getAttackerDeadArchersLvl3(): int
    {
        return $this->attackerDeadArchersLvl3;
    }

    /**
     * @param int $attackerDeadArchersLvl3
     */
    public function setAttackerDeadArchersLvl3(int $attackerDeadArchersLvl3): void
    {
        $this->attackerDeadArchersLvl3 = $attackerDeadArchersLvl3;
    }

    /**
     * @return int
     */
    public function getAttackerDeadCavalryLvl1(): int
    {
        return $this->attackerDeadCavalryLvl1;
    }

    /**
     * @param int $attackerDeadCavalryLvl1
     */
    public function setAttackerDeadCavalryLvl1(int $attackerDeadCavalryLvl1): void
    {
        $this->attackerDeadCavalryLvl1 = $attackerDeadCavalryLvl1;
    }

    /**
     * @return int
     */
    public function getAttackerDeadCavalryLvl2(): int
    {
        return $this->attackerDeadCavalryLvl2;
    }

    /**
     * @param int $attackerDeadCavalryLvl2
     */
    public function setAttackerDeadCavalryLvl2(int $attackerDeadCavalryLvl2): void
    {
        $this->attackerDeadCavalryLvl2 = $attackerDeadCavalryLvl2;
    }

    /**
     * @return int
     */
    public function getAttackerDeadCavalryLvl3(): int
    {
        return $this->attackerDeadCavalryLvl3;
    }

    /**
     * @param int $attackerDeadCavalryLvl3
     */
    public function setAttackerDeadCavalryLvl3(int $attackerDeadCavalryLvl3): void
    {
        $this->attackerDeadCavalryLvl3 = $attackerDeadCavalryLvl3;
    }

    /**
     * @return int
     */
    public function getDefenderRemainingFootmenLvl1(): int
    {
        return $this->defenderRemainingFootmenLvl1;
    }

    /**
     * @param int $defenderRemainingFootmenLvl1
     */
    public function setDefenderRemainingFootmenLvl1(int $defenderRemainingFootmenLvl1): void
    {
        $this->defenderRemainingFootmenLvl1 = $defenderRemainingFootmenLvl1;
    }

    /**
     * @return int
     */
    public function getDefenderRemainingFootmenLvl2(): int
    {
        return $this->defenderRemainingFootmenLvl2;
    }

    /**
     * @param int $defenderRemainingFootmenLvl2
     */
    public function setDefenderRemainingFootmenLvl2(int $defenderRemainingFootmenLvl2): void
    {
        $this->defenderRemainingFootmenLvl2 = $defenderRemainingFootmenLvl2;
    }

    /**
     * @return int
     */
    public function getDefenderRemainingFootmenLvl3(): int
    {
        return $this->defenderRemainingFootmenLvl3;
    }

    /**
     * @param int $defenderRemainingFootmenLvl3
     */
    public function setDefenderRemainingFootmenLvl3(int $defenderRemainingFootmenLvl3): void
    {
        $this->defenderRemainingFootmenLvl3 = $defenderRemainingFootmenLvl3;
    }

    /**
     * @return int
     */
    public function getDefenderRemainingArchersLvl1(): int
    {
        return $this->defenderRemainingArchersLvl1;
    }

    /**
     * @param int $defenderRemainingArchersLvl1
     */
    public function setDefenderRemainingArchersLvl1(int $defenderRemainingArchersLvl1): void
    {
        $this->defenderRemainingArchersLvl1 = $defenderRemainingArchersLvl1;
    }

    /**
     * @return int
     */
    public function getDefenderRemainingArchersLvl2(): int
    {
        return $this->defenderRemainingArchersLvl2;
    }

    /**
     * @param int $defenderRemainingArchersLvl2
     */
    public function setDefenderRemainingArchersLvl2(int $defenderRemainingArchersLvl2): void
    {
        $this->defenderRemainingArchersLvl2 = $defenderRemainingArchersLvl2;
    }

    /**
     * @return int
     */
    public function getDefenderRemainingArchersLvl3(): int
    {
        return $this->defenderRemainingArchersLvl3;
    }

    /**
     * @param int $defenderRemainingArchersLvl3
     */
    public function setDefenderRemainingArchersLvl3(int $defenderRemainingArchersLvl3): void
    {
        $this->defenderRemainingArchersLvl3 = $defenderRemainingArchersLvl3;
    }

    /**
     * @return int
     */
    public function getDefenderRemainingCavalryLvl1(): int
    {
        return $this->defenderRemainingCavalryLvl1;
    }

    /**
     * @param int $defenderRemainingCavalryLvl1
     */
    public function setDefenderRemainingCavalryLvl1(int $defenderRemainingCavalryLvl1): void
    {
        $this->defenderRemainingCavalryLvl1 = $defenderRemainingCavalryLvl1;
    }

    /**
     * @return int
     */
    public function getDefenderRemainingCavalryLvl2(): int
    {
        return $this->defenderRemainingCavalryLvl2;
    }

    /**
     * @param int $defenderRemainingCavalryLvl2
     */
    public function setDefenderRemainingCavalryLvl2(int $defenderRemainingCavalryLvl2): void
    {
        $this->defenderRemainingCavalryLvl2 = $defenderRemainingCavalryLvl2;
    }

    /**
     * @return int
     */
    public function getDefenderRemainingCavalryLvl3(): int
    {
        return $this->defenderRemainingCavalryLvl3;
    }

    /**
     * @param int $defenderRemainingCavalryLvl3
     */
    public function setDefenderRemainingCavalryLvl3(int $defenderRemainingCavalryLvl3): void
    {
        $this->defenderRemainingCavalryLvl3 = $defenderRemainingCavalryLvl3;
    }

    /**
     * @return int
     */
    public function getDefenderDeadFootmenLvl1(): int
    {
        return $this->defenderDeadFootmenLvl1;
    }

    /**
     * @param int $defenderDeadFootmenLvl1
     */
    public function setDefenderDeadFootmenLvl1(int $defenderDeadFootmenLvl1): void
    {
        $this->defenderDeadFootmenLvl1 = $defenderDeadFootmenLvl1;
    }

    /**
     * @return int
     */
    public function getDefenderDeadFootmenLvl2(): int
    {
        return $this->defenderDeadFootmenLvl2;
    }

    /**
     * @param int $defenderDeadFootmenLvl2
     */
    public function setDefenderDeadFootmenLvl2(int $defenderDeadFootmenLvl2): void
    {
        $this->defenderDeadFootmenLvl2 = $defenderDeadFootmenLvl2;
    }

    /**
     * @return int
     */
    public function getDefenderDeadFootmenLvl3(): int
    {
        return $this->defenderDeadFootmenLvl3;
    }

    /**
     * @param int $defenderDeadFootmenLvl3
     */
    public function setDefenderDeadFootmenLvl3(int $defenderDeadFootmenLvl3): void
    {
        $this->defenderDeadFootmenLvl3 = $defenderDeadFootmenLvl3;
    }

    /**
     * @return int
     */
    public function getDefenderDeadArchersLvl1(): int
    {
        return $this->defenderDeadArchersLvl1;
    }

    /**
     * @param int $defenderDeadArchersLvl1
     */
    public function setDefenderDeadArchersLvl1(int $defenderDeadArchersLvl1): void
    {
        $this->defenderDeadArchersLvl1 = $defenderDeadArchersLvl1;
    }

    /**
     * @return int
     */
    public function getDefenderDeadArchersLvl2(): int
    {
        return $this->defenderDeadArchersLvl2;
    }

    /**
     * @param int $defenderDeadArchersLvl2
     */
    public function setDefenderDeadArchersLvl2(int $defenderDeadArchersLvl2): void
    {
        $this->defenderDeadArchersLvl2 = $defenderDeadArchersLvl2;
    }

    /**
     * @return int
     */
    public function getDefenderDeadArchersLvl3(): int
    {
        return $this->defenderDeadArchersLvl3;
    }

    /**
     * @param int $defenderDeadArchersLvl3
     */
    public function setDefenderDeadArchersLvl3(int $defenderDeadArchersLvl3): void
    {
        $this->defenderDeadArchersLvl3 = $defenderDeadArchersLvl3;
    }

    /**
     * @return int
     */
    public function getDefenderDeadCavalryLvl1(): int
    {
        return $this->defenderDeadCavalryLvl1;
    }

    /**
     * @param int $defenderDeadCavalryLvl1
     */
    public function setDefenderDeadCavalryLvl1(int $defenderDeadCavalryLvl1): void
    {
        $this->defenderDeadCavalryLvl1 = $defenderDeadCavalryLvl1;
    }

    /**
     * @return int
     */
    public function getDefenderDeadCavalryLvl2(): int
    {
        return $this->defenderDeadCavalryLvl2;
    }

    /**
     * @param int $defenderDeadCavalryLvl2
     */
    public function setDefenderDeadCavalryLvl2(int $defenderDeadCavalryLvl2): void
    {
        $this->defenderDeadCavalryLvl2 = $defenderDeadCavalryLvl2;
    }

    /**
     * @return int
     */
    public function getDefenderDeadCavalryLvl3(): int
    {
        return $this->defenderDeadCavalryLvl3;
    }

    /**
     * @param int $defenderDeadCavalryLvl3
     */
    public function setDefenderDeadCavalryLvl3(int $defenderDeadCavalryLvl3): void
    {
        $this->defenderDeadCavalryLvl3 = $defenderDeadCavalryLvl3;
    }

    /**
     * Set attacker.
     *
     * @param string $attacker
     *
     * @return BattleReports
     */
    public function setAttacker($attacker)
    {
        $this->attacker = $attacker;

        return $this;
    }

    /**
     * Get attacker.
     *
     * @return string
     */
    public function getAttacker()
    {
        return $this->attacker;
    }

    /**
     * Set defender.
     *
     * @param string $defender
     *
     * @return BattleReports
     */
    public function setDefender($defender)
    {
        $this->defender = $defender;

        return $this;
    }

    /**
     * Get defender.
     *
     * @return string
     */
    public function getDefender()
    {
        return $this->defender;
    }

    /**
     * Set battleDate.
     *
     * @param \DateTime $battleDate
     *
     * @return BattleReports
     */
    public function setBattleDate($battleDate)
    {
        $this->battleDate = $battleDate;

        return $this;
    }

    /**
     * Get battleDate.
     *
     * @return \DateTime
     */
    public function getBattleDate()
    {
        return $this->battleDate;
    }

    /**
     * Set winner.
     *
     * @param string $winner
     *
     * @return BattleReports
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner.
     *
     * @return string
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Set gainedFood.
     *
     * @param int $gainedFood
     *
     * @return BattleReports
     */
    public function setGainedFood($gainedFood)
    {
        $this->gainedFood = $gainedFood;

        return $this;
    }

    /**
     * Get gainedFood.
     *
     * @return int
     */
    public function getGainedFood()
    {
        return $this->gainedFood;
    }

    /**
     * Set gainedMetal.
     *
     * @param int $gainedMetal
     *
     * @return BattleReports
     */
    public function setGainedMetal($gainedMetal)
    {
        $this->gainedMetal = $gainedMetal;

        return $this;
    }

    /**
     * Get gainedMetal.
     *
     * @return int
     */
    public function getGainedMetal()
    {
        return $this->gainedMetal;
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
    public function setReturnDate(\DateTime $returnDate): void
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

    /**
     * @return bool
     */
    public function isArmyReturnedToCastle(): bool
    {
        return $this->armyReturnedToCastle;
    }

    /**
     * @param bool $armyReturnedToCastle
     */
    public function setArmyReturnedToCastle(bool $armyReturnedToCastle): void
    {
        $this->armyReturnedToCastle = $armyReturnedToCastle;
    }

    /**
     * @return bool
     */
    public function isVisited(): bool
    {
        return $this->visited;
    }

    /**
     * @param bool $visited
     */
    public function setVisited(bool $visited): void
    {
        $this->visited = $visited;
    }
}
