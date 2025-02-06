<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $addresses = [
            [
                'firstname' => 'Aliou',
                'lastname' => 'Diop',
                'address' => '123 Avenue de l\'Indépendance',
                'postal' => '00221',
                'city' => 'Dakar',
                'country' => 'Sénégal',
                'phone' => '+221 77 123 45 67',
                'user' => 0
            ],
            [
                'firstname' => 'Fatou',
                'lastname' => 'Sow',
                'address' => '456 Rue du Marché',
                'postal' => '22501',
                'city' => 'Abidjan',
                'country' => 'Côte d\'Ivoire',
                'phone' => '+225 05 6789 1234',
                'user' => 1
            ],
            [
                'firstname' => 'Mohamed',
                'lastname' => 'Koné',
                'address' => '789 Boulevard de la Paix',
                'postal' => '24300',
                'city' => 'Bamako',
                'country' => 'Mali',
                'phone' => '+223 65 432 1098',
                'user' => 2
            ]
        ];

        foreach ($addresses as $data) {
            $address = new Address();
            $address->setFirstname($data['firstname']);
            $address->setLastname($data['lastname']);
            $address->setAddress($data['address']);
            $address->setPostal($data['postal']);
            $address->setCity($data['city']);
            $address->setCountry($data['country']);
            $address->setPhone($data['phone']);
            $address->setUser($this->getReference('user_' . $data['user']));

            $manager->persist($address);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class, // Assure-toi que les utilisateurs existent déjà
        ];
    }
}
