<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Castle;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping;

/**
 * CastleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CastleRepository extends \Doctrine\ORM\EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em,new Mapping\ClassMetadata(Castle::class));
    }
}