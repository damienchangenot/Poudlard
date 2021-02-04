<?php

namespace App\DataFixtures;

use App\Entity\House;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HouseFixtures extends Fixture
{
    private const HOUSE = ['Gryffondor', 'Serdaigle', 'Serpentard', 'Poufsouffle'];

    public function load(ObjectManager $manager)
    {
        foreach (self::HOUSE as $key => $houseName) {
            $house = new House();
            $house->setName($houseName);
            $manager->persist($house);
            $this->addReference('house_' . $key, $house);
        }
        $manager->flush();
    }

}
