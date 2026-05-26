<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $productsData = [
            [
                'name' => 'Camomille',
                'slug' => 'camomille',
                'price' => 9.90,
                'description' => 'La camomille est une plante reconnue pour ses propriétés apaisantes et digestives. Elle aide à favoriser le sommeil et à réduire le stress du quotidien.',
                'benefits' => "- Favorise l’endormissement\n- Apaise les tensions nerveuses\n- Contribue au confort digestif",
                'usage' => "- En infusion : 1 à 2 cuillères à café pour une tasse d’eau chaude\n- 2 à 3 tasses par jour\n- À consommer de préférence le soir",
                'imageName' => 'camomille.jpg',
            ],
            [
                'name' => 'Thym',
                'slug' => 'thym',
                'price' => 7.50,
                'description' => 'Le thym est traditionnellement utilisé pour soutenir les voies respiratoires et les défenses naturelles, notamment en période hivernale.',
                'benefits' => "- Soutient les défenses naturelles\n- Aide au confort respiratoire\n- Propriétés antiseptiques douces",
                'usage' => "- En infusion : 1 cuillère à café pour une tasse\n- 2 à 3 tasses par jour\n- Peut être associé au miel et au citron",
                'imageName' => 'thym.jpg',
            ],
            [
                'name' => 'Nigelle',
                'slug' => 'nigelle',
                'price' => 12.90,
                'description' => 'La nigelle (cumin noir) est connue pour ses propriétés antioxydantes et son soutien du système immunitaire.',
                'benefits' => "- Effet antioxydant\n- Soutient le système immunitaire\n- Aide au confort digestif",
                'usage' => "- À saupoudrer sur les plats ou en tisane\n- 1 à 2 cuillères à café par jour\n- À adapter selon les conseils d’un professionnel",
                'imageName' => 'nigelle.jpg',
            ],
            [
                'name' => 'Moringa',
                'slug' => 'moringa',
                'price' => 14.50,
                'description' => 'Le moringa est une plante riche en nutriments, souvent utilisée comme soutien général de l’organisme.',
                'benefits' => "- Soutien général de l’organisme\n- Apport en vitamines et minéraux\n- Aide à réduire la fatigue",
                'usage' => "- En infusion ou en poudre mélangée à une boisson\n- 1 cuillère à café par jour au début\n- À augmenter progressivement si besoin",
                'imageName' => 'moringa.jpg',
            ],
        ];

        foreach ($productsData as $data) {
            $product = new Product();
            $product
                ->setName($data['name'])
                ->setSlug($data['slug'])
                ->setPrice($data['price'])
                ->setDescription($data['description'])
                ->setBenefits($data['benefits'])
                ->setUsage($data['usage'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
            ;

            $product->setImageName($data['imageName']);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
