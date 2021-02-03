<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class TeacherFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $teacher = new Teacher();
            $image = 'https://loremflickr.com/320/240/';
            $imageName = uniqid() .'.jpg';
            copy($image, __DIR__ . '/../../public/uploads/' . $imageName);
            $teacher->setUser($this->getReference('student_'. $i));
            $teacher->setName($faker->name);
            $teacher->setPicture($imageName);
            $teacher->setSubject($faker->word);
            $this->addReference('teacher_'. $i, $teacher);
            $manager->persist($teacher);
        }

        $manager->flush();
    }
}
