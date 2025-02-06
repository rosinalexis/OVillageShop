<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $products = [
            [
                'name' => 'Riz Basmati',
                'description' => 'Un riz parfumé et léger, idéal pour accompagner vos plats africains.',
                'illustration' => 'https://example.com/riz-basmati.jpg',
                'price' => 5000,
                'tva' => 10,
                'category' => 0,
                'isHomepage' => true
            ],
            [
                'name' => 'Mil (Petit mil)',
                'description' => 'Une céréale nutritive consommée dans toute l\'Afrique de l\'Ouest.',
                'illustration' => 'https://example.com/mil.jpg',
                'price' => 3500,
                'tva' => 5,
                'category' => 0,
                'isHomepage' => false
            ],
            [
                'name' => 'Poisson Séché (Capitaine)',
                'description' => 'Poisson séché traditionnellement utilisé pour les sauces et soupes.',
                'illustration' => 'https://example.com/poisson-seche.jpg',
                'price' => 7000,
                'tva' => 20,
                'category' => 1,
                'isHomepage' => true
            ],
            [
                'name' => 'Jus de Bissap',
                'description' => 'Boisson rafraîchissante à base de fleurs d\'hibiscus.',
                'illustration' => 'https://example.com/bissap.jpg',
                'price' => 1200,
                'tva' => 5,
                'category' => 3,
                'isHomepage' => true
            ],
            [
                'name' => 'Chocolat Artisanal Africain',
                'description' => 'Chocolat fait à partir de fèves de cacao africaines, 100% naturel.',
                'illustration' => 'https://example.com/chocolat-africain.jpg',
                'price' => 2500,
                'tva' => 5,
                'category' => 4,
                'isHomepage' => false
            ]
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData['name']);
            $product->setSlug(strtolower($this->slugger->slug($productData['name'])));
            $product->setDescription($productData['description']);
            $product->setIllustration($productData['illustration']);
            $product->setPrice($productData['price']);
            $product->setTva($productData['tva']);
            $product->setCategory($this->getReference('category_' . $productData['category']));
            $product->setIsHomepage($productData['isHomepage']);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
