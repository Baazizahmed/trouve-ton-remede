<?php

namespace App\Controller\Visitor\Product;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/produits', name: 'app_visitor_product_index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('pages/visitor/product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/produits/{slug}', name: 'app_visitor_product_show')]
    public function show(string $slug, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé.');
        }

        return $this->render('pages/visitor/product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
