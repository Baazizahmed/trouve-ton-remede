<?php

namespace App\Service;

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

        // getOrCreateCart() renvoie toujours un Cart, jamais null
        $cart = $this->cartService->getOrCreateCart($user);

        $count = 0;

        foreach ($cart->getCartItems() as $item) {
            $count += $item->getQuantity();
        }

        return $count;
    }
}
