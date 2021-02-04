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
        for ($i = 0; $i <= 19; $i++) {
            $student = new Student();
            $image= 'https://loremflickr.com/320/240/';
            $imageName = uniqid() .'.jpg';
            copy($image, __DIR__ . '/../../public/uploads/' . $imageName);

            $student->setName($faker->name);
            $student->setPicture($imageName);
            $student->setIsTeacher(false);
            $student->setUser($this->getReference('student_'. $i));
            $student->setHouse($this->getReference('house_'.rand(0,3)));
            $manager->persist($student);

        }

        for ($i = 20; $i <= 40; $i++) {
            $teacher = new Student();
            $image = 'https://loremflickr.com/320/240/';
            $imageName = uniqid() . '.jpg';
            copy($image, __DIR__ . '/../../public/uploads/' . $imageName);
            $teacher->setName($faker->name);
            $teacher->setPicture($imageName);
            $teacher->setIsTeacher(true);
            $teacher->setUser($this->getReference('teacher_' . $i));
            $teacher->setSubject($faker->word);
            $manager->persist($teacher);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [HouseFixtures::class, UserFixtures::class];
    }
}
