<?php

namespace App\DataFixtures;


use App\Entity\Bien;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * class Bien fixtures
 */
class BienFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $villes = ['Paris', 'Versailles', 'Gambais', 'Houdan', 'Rambouillet'];
        for ($j = 0; $j < 40; $j++) {
            $pieces = mt_rand(1, 4);
            $bien = new Bien();
            $bien->setNbPieces($pieces)
                ->setDescription('Maison avec ' . $pieces . ' chambre ')
                ->setAdresse(rand(1,25) .' '. 'rue de la ville')
                ->setCodePostal(rand(75000, 95000))
                ->setVille($villes[rand(0,4)])
                ->setAutres(['Toilette', 'salle de bain', 'douche']);
            $manager->persist($bien);
        }
        $manager->flush();
    }
}
