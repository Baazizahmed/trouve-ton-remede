<?php

namespace App\Controller\User\Cart;

use App\Repository\CartItemRepository;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    public function __construct(
        private CartService $cartService,
    ) {
    }

    #[Route('/panier', name: 'app_cart_index')]
    public function index(): Response
    {
        $cart = $this->cartService->getOrCreateCart($this->getUser());
        $total = $this->cartService->getTotal($cart);

        return $this->render('pages/user/cart/index.html.twig', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    #[Route('/panier/ajouter/{id}', name: 'app_cart_add', methods: ['POST'])]
    public function add(int $id, Request $request, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé.');
        }

        $quantity = (int) $request->request->get('quantity', 1);
        $cart = $this->cartService->getOrCreateCart($this->getUser());
        $this->cartService->addProduct($cart, $product, $quantity);

        $this->addFlash('success', $product->getName().' ajouté au panier.');

        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/panier/supprimer/{id}', name: 'app_cart_remove', methods: ['POST'])]
    public function remove(int $id, CartItemRepository $cartItemRepository): Response
    {
        $cartItem = $cartItemRepository->find($id);

        if (!$cartItem) {
            throw $this->createNotFoundException('Article non trouvé.');
        }

        $cart = $this->cartService->getOrCreateCart($this->getUser());
        $this->cartService->removeProduct($cart, $cartItem);

        $this->addFlash('success', 'Article supprimé du panier.');

        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/panier/modifier/{id}', name: 'app_cart_update', methods: ['POST'])]
    public function update(int $id, Request $request, CartItemRepository $cartItemRepository): Response
    {
        $cartItem = $cartItemRepository->find($id);

        if (!$cartItem) {
            throw $this->createNotFoundException('Article non trouvé.');
        }

        $quantity = (int) $request->request->get('quantity', 1);
        $this->cartService->updateQuantity($cartItem, $quantity);

        $this->addFlash('success', 'Quantité mise à jour.');

        return $this->redirectToRoute('app_cart_index');
    }
}
