<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use App\Entity\PFE;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
class PFEFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $pfe = new PFE();
            $pfe->setTitle($faker->sentence);
            $pfe->setStudent($faker->name);
            //link to entreprise
            $pfe->setEntreprise($this->getReference('entreprise' . $i));

            $manager->persist($pfe);
        }
        $manager->flush();
    }
}
