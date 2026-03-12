<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Cart;
use App\Entity\User;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    public function __construct(
        private EntityManagerInterface $em,
        private OrderRepository $orderRepository,
    ) {}

    public function createOrderFromCart(Cart $cart, User $user): Order
    {
        $order = new Order();
        $order->setUser($user);
        $order->setStatus('PENDING');
        $order->setCreatedAt(new \DateTimeImmutable());

        $subtotalHt = 0;

        foreach ($cart->getCartItems() as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->setProductName($cartItem->getProduct()->getName());
            $orderItem->setQuantity($cartItem->getQuantity());
            $orderItem->setUnitPriceHt($cartItem->getUnitPrice());
            $orderItem->setTaxRate('20.00'); // TVA 20% par défaut
            $orderItem->setProduct($cartItem->getProduct());

            $totalHt = $cartItem->getUnitPrice() * $cartItem->getQuantity();
            $totalTtc = $totalHt * 1.20;

            $orderItem->setTotalHt((string) $totalHt);
            $orderItem->setTotalTtc((string) $totalTtc);
            $orderItem->setOrderRef($order);

            $order->addOrderItem($orderItem);
            $subtotalHt += $totalHt;
        }

        $taxAmount = $subtotalHt * 0.20;
        $totalTtc = $subtotalHt + $taxAmount;

        $order->setSubtotalHt((string) $subtotalHt);
        $order->setTaxAmount((string) $taxAmount);
        $order->setTotalTtc((string) $totalTtc);

        $this->em->persist($order);
        $this->em->flush();

        return $order;
    }

    public function getUserOrders(User $user): array
    {
        return $this->orderRepository->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC']
        );
    }
}
