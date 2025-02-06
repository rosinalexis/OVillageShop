<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Carrier;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CarrierFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $carriers = [
            ['DHL', 'Livraison rapide en 24h partout en Afrique.', 10.99],
            ['UPS', 'Livraison sécurisée avec suivi en temps réel.', 8.50],
            ['Colis Privé', 'Livraison standard en 3 à 5 jours.', 5.99],
            ['La Poste', 'Livraison économique avec assurance.', 4.99],
            ['Express Africa', 'Spécialiste des envois locaux ultra-rapides.', 6.99]
        ];

        foreach ($carriers as $index => $data) {
            $carrier = new Carrier();
            $carrier->setName($data[0]);
            $carrier->setDescription($data[1]);
            $carrier->setPrice($data[2]);

            $manager->persist($carrier);
            $this->addReference('carrier_' . $index, $carrier); // 🔥 Ajout de références si besoin
        }

        $manager->flush();
    }
}
