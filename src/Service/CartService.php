<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CartRepository;
use App\Repository\CartItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    public function __construct(
        private EntityManagerInterface $em,
        private CartRepository $cartRepository,
        private CartItemRepository $cartItemRepository,
        private RequestStack $requestStack,
    ) {}

    // Récupère ou crée un panier pour l'utilisateur ou la session
    public function getOrCreateCart(?User $user): Cart
    {
        $session = $this->requestStack->getSession();
        $sessionId = $session->getId();

        if ($user) {
            $cart = $this->cartRepository->findOneBy([
                'user' => $user,
                'status' => 'OPEN',
            ]);
        } else {
            $cart = $this->cartRepository->findOneBy([
                'sessionId' => $sessionId,
                'status' => 'OPEN',
            ]);
        }

        if (!$cart) {
            $cart = new Cart();
            $cart->setStatus('OPEN');
            $cart->setCreatedAt(new \DateTimeImmutable());
            $cart->setUpdatedAt(new \DateTimeImmutable());

            if ($user) {
                $cart->setUser($user);
            } else {
                $cart->setSessionId($sessionId);
            }

            $this->em->persist($cart);
            $this->em->flush();
        }

        return $cart;
    }

    // Ajouter un produit au panier
    public function addProduct(Cart $cart, Product $product, int $quantity = 1): void
    {
        $cartItem = $this->cartItemRepository->findOneBy([
            'cart' => $cart,
            'product' => $product,
        ]);

        if ($cartItem) {
            $cartItem->setQuantity($cartItem->getQuantity() + $quantity);
        } else {
            $cartItem = new CartItem();
            $cartItem->setCart($cart);
            $cartItem->setProduct($product);
            $cartItem->setQuantity($quantity);
            $cartItem->setUnitPrice($product->getPrice());
            $this->em->persist($cartItem);
        }

        $cart->setUpdatedAt(new \DateTimeImmutable());
        $this->em->flush();
    }

    // Supprimer un produit du panier
    public function removeProduct(Cart $cart, CartItem $cartItem): void
    {
        $cart->removeCartItem($cartItem);
        $cart->setUpdatedAt(new \DateTimeImmutable());
        $this->em->flush();
    }

    // Modifier la quantité d'un produit
    public function updateQuantity(CartItem $cartItem, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->em->remove($cartItem);
        } else {
            $cartItem->setQuantity($quantity);
        }
        $this->em->flush();
    }

    // Calculer le total du panier
    public function getTotal(Cart $cart): float
    {
        $total = 0;
        foreach ($cart->getCartItems() as $item) {
            $total += $item->getUnitPrice() * $item->getQuantity();
        }
        return $total;
    }
}
