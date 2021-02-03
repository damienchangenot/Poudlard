<?php

namespace App\DataFixtures;

use App\Entity\House;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HouseFixtures extends Fixture implements DependentFixtureInterface
{
    private const HOUSE = ['Gryffondor', 'Serdaigle', 'Serpentard', 'Poufsouffle'];

    public function load(ObjectManager $manager)
    {
        foreach (self::HOUSE as $key => $houseName) {
            $house = new House();
            $house->setName($houseName);
            $house->setTeacher($this->getReference('teacher_' . rand(0, 19)));
            $manager->persist($house);
            $this->addReference('house_' . $key, $house);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [TeacherFixtures::class];
    }
}
