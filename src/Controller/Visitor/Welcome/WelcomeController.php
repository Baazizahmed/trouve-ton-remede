<?php

namespace App\Controller\Visitor\Welcome;

use App\Repository\PostRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WelcomeController extends AbstractController
{
    public function __construct(
        private PostRepository $postRepository,
        private ProductRepository $productRepository,
    ) {
    }

    #[Route('/', name: 'app_visitor_welcome', methods: ['GET'])]
    public function index(): Response
    {
        $posts = $this->postRepository->findBy(
            ['isPublished' => true],
            ['publishedAt' => 'DESC'],
            3
        );

        // Produits mis en avant : pour l'instant, on prend les derniers produits créés
        $featuredProducts = $this->productRepository->findBy(
            [],
            ['createdAt' => 'DESC'],
            4
        );

        return $this->render('pages/visitor/welcome/index.html.twig', [
            'posts' => $posts,
            'featuredProducts' => $featuredProducts,
        ]);
    }
}
