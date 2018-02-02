<?php
/**
 * Created by PhpStorm.
 * User: Ivailo
 * Date: 2.2.2018 г.
 * Time: 13:29 ч.
 */

namespace AppBundle\Service;


use AppBundle\Entity\BuildingUpdateProperties;
use AppBundle\Repository\BuildingUpdatePropertiesRepository;
use Doctrine\ORM\EntityManagerInterface;

class BuildingUpdatePropertiesService implements BuildingUpdatePropertiesServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var BuildingUpdatePropertiesRepository
     */
    private $buildingUpdatePropertiesRepository;

    /**
     * UserService constructor.
     * @param BuildingUpdatePropertiesRepository $buildingUpdatePropertiesRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(BuildingUpdatePropertiesRepository $buildingUpdatePropertiesRepository, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->buildingUpdatePropertiesRepository = $buildingUpdatePropertiesRepository;
    }

    /**
     * @return null
     */
    public function createBuildingUpdateProperties()
    {
        $castle = new BuildingUpdateProperties();
        $castle->setName('Castle');
        $castle->setLevel1Food(100);
        $castle->setLevel1Metal(0);
        $castle->setLevel2Food(500);
        $castle->setLevel2Metal(500);
        $castle->setLevel3Food(1500);
        $castle->setLevel3Metal(1500);
        $castle->setLevel1Timer(40);
        $castle->setLevel2Timer(80);
        $castle->setLevel3Timer(160);

        $farm = new BuildingUpdateProperties();
        $farm->setName('Farm');
        $farm->setLevel1Food(100);
        $farm->setLevel1Metal(0);
        $farm->setLevel2Food(250);
        $farm->setLevel2Metal(100);
        $farm->setLevel3Food(500);
        $farm->setLevel3Metal(250);
        $farm->setLevel1Timer(20);
        $farm->setLevel2Timer(40);
        $farm->setLevel3Timer(80);

        $metalMine = new BuildingUpdateProperties();
        $metalMine->setName('Metal Mine');
        $metalMine->setLevel1Food(200);
        $metalMine->setLevel1Metal(0);
        $metalMine->setLevel2Food(300);
        $metalMine->setLevel2Metal(300);
        $metalMine->setLevel3Food(500);
        $metalMine->setLevel3Metal(500);
        $metalMine->setLevel1Timer(20);
        $metalMine->setLevel2Timer(40);
        $metalMine->setLevel3Timer(80);

        $footmen = new BuildingUpdateProperties();
        $footmen->setName('Footmen');
        $footmen->setLevel1Food(500);
        $footmen->setLevel1Metal(0);
        $footmen->setLevel2Food(1000);
        $footmen->setLevel2Metal(500);
        $footmen->setLevel3Food(1500);
        $footmen->setLevel3Metal(1000);
        $footmen->setLevel1Timer(30);
        $footmen->setLevel2Timer(60);
        $footmen->setLevel3Timer(120);

        $archers = new BuildingUpdateProperties();
        $archers->setName('Archers');
        $archers->setLevel1Food(500);
        $archers->setLevel1Metal(500);
        $archers->setLevel2Food(1000);
        $archers->setLevel2Metal(1000);
        $archers->setLevel3Food(1500);
        $archers->setLevel3Metal(1500);
        $archers->setLevel1Timer(30);
        $archers->setLevel2Timer(60);
        $archers->setLevel3Timer(120);

        $cavalry = new BuildingUpdateProperties();
        $cavalry->setName('Cavalry');
        $cavalry->setLevel1Food(1000);
        $cavalry->setLevel1Metal(1000);
        $cavalry->setLevel2Food(2000);
        $cavalry->setLevel2Metal(2000);
        $cavalry->setLevel3Food(3500);
        $cavalry->setLevel3Metal(3500);
        $cavalry->setLevel1Timer(60);
        $cavalry->setLevel2Timer(120);
        $cavalry->setLevel3Timer(240);

        $this->em->persist($castle);
        $this->em->persist($farm);
        $this->em->persist($metalMine);
        $this->em->persist($footmen);
        $this->em->persist($archers);
        $this->em->persist($cavalry);
        $this->em->flush();

        return null;
    }
}