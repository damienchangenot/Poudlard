<?php

namespace App\DataFixtures;

use App\Entity\Actuality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ActualityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $image= 'https://loremflickr.com/640/480/';
            $imageName = uniqid() .'.jpg';
            copy($image, __DIR__ . '/../../public/uploads/' . $imageName);
            $actuality = new Actuality();
            $actuality->setTitle($faker->sentence());
            $actuality->setDescription($faker->text);
            $actuality->setPicture($imageName);
            $manager->persist($actuality);
        }
        $manager->flush();
    }
}
