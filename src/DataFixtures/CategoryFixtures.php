<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Céréales & Farines',
            'Viandes & Poissons',
            'Fruits & Légumes',
            'Boissons',
            'Épices & Condiments',
        ];

        foreach ($categories as $index => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setSlug(strtolower($this->slugger->slug($categoryName)));

            $manager->persist($category);

            // Sauvegarde une référence pour les produits
            $this->addReference('category_' . $index, $category);
        }

        $manager->flush();
    }
}
