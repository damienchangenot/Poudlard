<?php

namespace App\DataFixtures;

use App\Entity\Director;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class DirectorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        $director = new Director();
        $image= 'https://loremflickr.com/320/240/';
        $imageName = uniqid() .'.jpg';
        copy($image, __DIR__ . '/../../public/uploads/' . $imageName);
        $director->setName($faker->name);
        $director->setPicture($imageName);
        $director->setPhoneNumber($faker->phoneNumber);
        $director->setUser($this->getReference('adminuser'));
        $manager->persist($director);
        $this->addReference('director', $director);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
