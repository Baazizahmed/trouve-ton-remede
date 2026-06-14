<?php

namespace App\Controller\Admin\Product;

use App\Entity\Product;
use App\Form\AdminProductFormType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/produits')]
final class ProductController extends AbstractController
{
    #[Route('', name: 'app_admin_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('pages/admin/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'app_admin_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();
        $now = new \DateTimeImmutable();
        $product->setCreatedAt($now);
        $product->setUpdatedAt($now);

        $form = $this->createForm(AdminProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit créé avec succès.');

            return $this->redirectToRoute('app_admin_product_index');
        }

        return $this->render('pages/admin/product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_admin_product_edit', methods: ['GET', 'POST'])]
    public function edit(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AdminProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedAt(new \DateTimeImmutable());
            $em->flush();

            $this->addFlash('success', 'Produit modifié avec succès.');

            return $this->redirectToRoute('app_admin_product_index');
        }

        return $this->render('pages/admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/stock', name: 'app_admin_product_stock_update', methods: ['POST'])] // AJOUT : route dédiée à la mise à jour rapide du stock
    public function updateStock(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        // AJOUT : sécurisation CSRF spécifique à la ligne produit
        if (!$this->isCsrfTokenValid('update_stock_'.$product->getId(), (string) $request->request->get('_token'))) {
            $this->addFlash('error', 'Jeton invalide. Merci de réessayer.');

            return $this->redirectToRoute('app_admin_product_index');
        }

        // AJOUT : récupération du stock avec garde-fou pour éviter les valeurs négatives
        $stock = max(0, (int) $request->request->get('stock', 0));

        $product->setStock($stock);
        $product->setUpdatedAt(new \DateTimeImmutable()); // AJOUT : on garde updatedAt cohérent avec la modif admin
        $em->flush();

        $this->addFlash('success', 'Stock mis à jour avec succès.');

        return $this->redirectToRoute('app_admin_product_index');
    }

    #[Route('/{id}/supprimer', name: 'app_admin_product_delete', methods: ['POST'])]
    public function delete(Product $product, EntityManagerInterface $em, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete_product_'.$product->getId(), (string) $request->request->get('_token'))) {
            $em->remove($product);
            $em->flush();

            $this->addFlash('success', 'Produit supprimé avec succès.');
        }

        return $this->redirectToRoute('app_admin_product_index');
    }
}
