<?php

namespace App\DataFixtures;

use App\Entity\Actuality;
use App\Services\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ActualityFixtures extends Fixture
{
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }
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
            $slug = $this->slugify->generate($actuality->getTitle());
            $actuality->setSlug($slug);
            $manager->persist($actuality);
        }
        $manager->flush();
    }
}
