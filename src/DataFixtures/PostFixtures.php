<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Catégorie plantes médicinales
        $category = $manager->getRepository(Category::class)->findOneBy(['name' => 'Plantes Médicinales']);
        if (!$category) {
            $category = new Category();
            $category->setName('Plantes Médicinales');
            $manager->persist($category);
        }

        // Tags communs
        $tagsData = ['sommeil', 'digestion', 'immunité', 'plante médicinale', 'tisane', 'bio'];
        $allTags = [];
        foreach ($tagsData as $tagName) {
            $tag = $manager->getRepository(Tag::class)->findOneBy(['name' => $tagName]);
            if (!$tag) {
                $tag = new Tag();
                $tag->setName($tagName);
                $manager->persist($tag);
            }
            $allTags[$tagName] = $tag;
        }

        // Post 1: Camomille
        $this->createPost($manager, $category, $allTags, [
            'title' => 'Camomille : La plante apaisante pour le sommeil et la digestion',
            'description' => 'Des plantes choisies pour le sommeil, la digestion, l’immunité et plus encore. La camomille est une plante reconnue pour ses propriétés apaisantes et digestives.',
            'keywords' => 'camomille, sommeil, digestion, tisane, apaisant',
            'content' => $this->getCamomilleContent(),
            'tags' => ['sommeil', 'digestion', 'tisane'],
        ]);

        // Post 2: Thym
        $this->createPost($manager, $category, $allTags, [
            'title' => 'Thym : Soutien respiratoire et défenses naturelles',
            'description' => 'Le thym est traditionnellement utilisé pour soutenir les voies respiratoires et les défenses naturelles de l’organisme.',
            'keywords' => 'thym, respiration, immunité, antiseptique, bio',
            'content' => $this->getThymContent(),
            'tags' => ['immunité', 'plante médicinale'],
        ]);

        // Post 3: Nigelle
        $this->createPost($manager, $category, $allTags, [
            'title' => 'Nigelle (Cumin Noir) : Antioxydants et soutien immunitaire',
            'description' => 'La nigelle (cumin noir) est connue pour ses propriétés antioxydantes et son soutien du système immunitaire.',
            'keywords' => 'nigelle, cumin noir, antioxydant, immunité, nigella sativa',
            'content' => $this->getNigelleContent(),
            'tags' => ['immunité', 'antioxydant'],
        ]);

        // Post 4: Moringa
        $this->createPost($manager, $category, $allTags, [
            'title' => 'Moringa : Le superaliment riche en nutriments',
            'description' => 'Le moringa est une plante riche en nutriments, souvent utilisée comme soutien général de l’organisme et booster d’énergie.',
            'keywords' => 'moringa, superaliment, nutriments, énergie, vitamines',
            'content' => $this->getMoringaContent(),
            'tags' => ['plante médicinale', 'bio'],
        ]);

        $manager->flush();
    }

    private function createPost(ObjectManager $manager, Category $category, array $allTags, array $data): Post
    {
        $post = new Post();
        $post->setTitle($data['title']);
        $post->setCategory($category);
        $post->setDescription($data['description']);
        $post->setKeywords($data['keywords']);
        $post->setContent($data['content']);

        // Tags spécifiques
        foreach ($data['tags'] as $tagName) {
            if (isset($allTags[$tagName])) {
                $post->addTag($allTags[$tagName]); // <-- au lieu de setTags()
            }
        }

        $manager->persist($post);

        $slug = strtolower(str_replace(' ', '-', $data['title']));
        $this->addReference('post-'.$slug, $post);

        return $post;
    }

    private function getCamomilleContent(): string
    {
        return '
        <h2>Camomille - La plante du sommeil et de la digestion</h2>
        <p><strong>9,90 €</strong> - Sachet de 50g</p>
        <h3>Propriétés principales :</h3>
        <ul>
            <li>Apaisante et favorise le sommeil</li>
            <li>Calme les troubles digestifs</li>
            <li>Antispasmodique naturel</li>
            <li>Anti-inflammatoire doux</li>
        </ul>
        <h3>Utilisation :</h3>
        <p>Infuser 1 cuillère à café dans 200ml d\'eau chaude pendant 5-10 minutes. À consommer en soirée ou après les repas.</p>
        ';
    }

    private function getThymContent(): string
    {
        return '
        <h2>Thym - Soutien respiratoire naturel</h2>
        <p><strong>7,50 €</strong> - Sachet de 50g</p>
        <h3>Propriétés principales :</h3>
        <ul>
            <li>Antiseptique des voies respiratoires</li>
            <li>Fortifie les défenses naturelles</li>
            <li>Antibactérien et antiviral</li>
            <li>Fluidifie le mucus</li>
        </ul>
        <h3>Utilisation :</h3>
        <p>Infuser 1-2 cuillères à café dans 250ml d\'eau bouillante pendant 10 minutes. Idéal en hiver.</p>
        ';
    }

    private function getNigelleContent(): string
    {
        return '
        <h2>Nigelle - L\'or noir de la santé</h2>
        <p><strong>12,90 €</strong> - Sachet de 100g</p>
        <h3>Propriétés principales :</h3>
        <ul>
            <li>Riche en antioxydants</li>
            <li>Soutien immunitaire puissant</li>
            <li>Anti-inflammatoire naturel</li>
            <li>Propriétés digestives</li>
        </ul>
        <h3>Utilisation :</h3>
        <p>1 cuillère à café par jour en cure de 21 jours, en infusion ou saupoudrée sur les aliments.</p>
        ';
    }

    private function getMoringaContent(): string
    {
        return '
        <h2>Moringa - Le superaliment miracle</h2>
        <p><strong>14,90 €</strong> - Sachet de 100g</p>
        <h3>Propriétés principales :</h3>
        <ul>
            <li>Exceptionnellement riche en nutriments</li>
            <li>Source naturelle de vitamines et minéraux</li>
            <li>Booste l\'énergie sans caféine</li>
            <li>Antioxydants puissants</li>
        </ul>
        <h3>Utilisation :</h3>
        <p>1 cuillère à café par jour dans un smoothie, yaourt ou infusion.</p>
        ';
    }
}
