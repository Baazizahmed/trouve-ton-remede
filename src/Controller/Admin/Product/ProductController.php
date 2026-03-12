<?php

namespace App\Controller\Admin\Product;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/produits')]
#[IsGranted('ROLE_ADMIN')]
class ProductController extends AbstractController
{
    #[Route('', name: 'app_admin_product_index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('pages/admin/product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/nouveau', name: 'app_admin_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        if ($request->isMethod('POST')) {
            $product = new Product();
            $product->setName($request->request->get('name'));
            $product->setSlug(strtolower($slugger->slug($request->request->get('name'))));
            $product->setDescription($request->request->get('description'));
            $product->setPrice($request->request->get('price'));
            $product->setCreatedAt(new \DateTimeImmutable());
            $product->setUpdatedAt(new \DateTimeImmutable());

            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit créé avec succès.');

            return $this->redirectToRoute('app_admin_product_index');
        }

        return $this->render('pages/admin/product/new.html.twig');
    }

    #[Route('/{id}/modifier', name: 'app_admin_product_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, ProductRepository $productRepository, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé.');
        }

        if ($request->isMethod('POST')) {
            $product->setName($request->request->get('name'));
            $product->setSlug(strtolower($slugger->slug($request->request->get('name'))));
            $product->setDescription($request->request->get('description'));
            $product->setPrice($request->request->get('price'));
            $product->setUpdatedAt(new \DateTimeImmutable());

            $em->flush();

            $this->addFlash('success', 'Produit modifié avec succès.');

            return $this->redirectToRoute('app_admin_product_index');
        }

        return $this->render('pages/admin/product/edit.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/supprimer', name: 'app_admin_product_delete', methods: ['POST'])]
    public function delete(int $id, ProductRepository $productRepository, EntityManagerInterface $em): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé.');
        }

        $em->remove($product);
        $em->flush();

        $this->addFlash('success', 'Produit supprimé.');

        return $this->redirectToRoute('app_admin_product_index');
    }
}
