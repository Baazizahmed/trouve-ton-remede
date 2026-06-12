<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CartCounter
{
    public function __construct(
        private CartService $cartService,
        private TokenStorageInterface $tokenStorage,
    ) {
    }

    public function getItemCount(): int
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;

        $cart = $this->cartService->getOrCreateCart(
            $user instanceof User ? $user : null
        );

        $count = 0;

        foreach ($cart->getCartItems() as $item) {
            $count += $item->getQuantity();
        }

        return $count;
    }
}
