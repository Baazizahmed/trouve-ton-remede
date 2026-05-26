<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            [
                'name' => 'Camomille',
                'slug' => 'camomille',
                'description' => 'Plante apaisante idéale pour le sommeil et la digestion.',
                'price' => '9.99',
            ],
            [
                'name' => 'Thym',
                'slug' => 'thym',
                'description' => 'Excellent pour les voies respiratoires et les infections.',
                'price' => '7.50',
            ],
            [
                'name' => 'Nigelle',
                'slug' => 'nigelle',
                'description' => 'Graine aux multiples vertus, anti-inflammatoire naturel.',
                'price' => '12.00',
            ],
            [
                'name' => 'Moringa',
                'slug' => 'moringa',
                'description' => 'Arbre de vie riche en nutriments et vitamines.',
                'price' => '15.00',
            ],
        ];

        foreach ($products as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setSlug($data['slug']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setCreatedAt(new \DateTimeImmutable());
            $product->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($product);
        }

        $manager->flush();
    }
}
