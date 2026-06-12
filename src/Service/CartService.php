<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CartItemRepository;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;

class CartService
{
    public function __construct(
        private EntityManagerInterface $em,
        private CartRepository $cartRepository,
        private CartItemRepository $cartItemRepository,
        private RequestStack $requestStack,
    ) {
    }

    public function findOpenCart(?UserInterface $user): ?Cart
    {
        $session = $this->requestStack->getSession();
        $sessionId = $session->getId();

        if ($user instanceof User) {
            return $this->cartRepository->findOneBy([
                'user' => $user,
                'status' => 'OPEN',
            ]);
        }

        return $this->cartRepository->findOneBy([
            'sessionId' => $sessionId,
            'status' => 'OPEN',
        ]);
    }

    public function getOrCreateCart(?UserInterface $user): Cart
    {
        $cart = $this->findOpenCart($user);

        if ($cart) {
            return $cart;
        }

        $session = $this->requestStack->getSession();
        $sessionId = $session->getId();

        $cart = new Cart();
        $cart->setStatus('OPEN');
        $cart->setCreatedAt(new \DateTimeImmutable());
        $cart->setUpdatedAt(new \DateTimeImmutable());

        if ($user instanceof User) {
            $cart->setUser($user);
        } else {
            $cart->setSessionId($sessionId);
        }

        $this->em->persist($cart);
        $this->em->flush();

        return $cart;
    }

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

    public function removeProduct(Cart $cart, CartItem $cartItem): void
    {
        $cart->removeCartItem($cartItem);
        $cart->setUpdatedAt(new \DateTimeImmutable());
        $this->em->flush();
    }

    public function updateQuantity(CartItem $cartItem, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->em->remove($cartItem);
        } else {
            $cartItem->setQuantity($quantity);
        }

        $this->em->flush();
    }

    public function getTotal(Cart $cart): float
    {
        $total = 0;

        foreach ($cart->getCartItems() as $item) {
            $total += $item->getUnitPrice() * $item->getQuantity();
        }

        return $total;
    }

    public function clearCart(Cart $cart): void
    {
        foreach ($cart->getCartItems() as $item) {
            $this->em->remove($item);
        }

        $cart->getCartItems()->clear();
        $cart->setStatus('ORDERED');
        $cart->setUpdatedAt(new \DateTimeImmutable());

        $this->em->flush();
    }
}
