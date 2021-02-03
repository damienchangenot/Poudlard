<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class StudentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $student = new Student();
            $image= 'https://loremflickr.com/320/240/';
            $imageName = uniqid() .'.jpg';
            copy($image, __DIR__ . '/../../public/uploads/' . $imageName);
            $student->setUser($this->getReference('student_'. $i));
            $student->setName($faker->name);
            $student->setPicture($imageName);
            $student->setHouse($this->getReference('house_'.rand(0,3)));
            $manager->persist($student);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [HouseFixtures::class];
    }
}
