<?php

namespace App\Controller\User\Order;

use App\Repository\OrderRepository;
use App\Service\CartService;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class OrderController extends AbstractController
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService,
    ) {}

    #[Route('/commande/valider', name: 'app_order_validate', methods: ['POST'])]
    public function validate(): Response
    {
        $user = $this->getUser();
        $cart = $this->cartService->getOrCreateCart($user);

        if ($cart->getCartItems()->isEmpty()) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('app_cart_index');
        }

        $order = $this->orderService->createOrderFromCart($cart, $user);

        // Vider le panier après validation
        $cart->setStatus('ORDERED');

        $this->addFlash('success', 'Commande validée avec succès !');

        return $this->redirectToRoute('app_order_show', ['id' => $order->getId()]);
    }

    #[Route('/commande/{id}', name: 'app_order_show')]
    public function show(int $id, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find($id);

        if (!$order || $order->getUser() !== $this->getUser()) {
            throw $this->createNotFoundException('Commande non trouvée.');
        }

        return $this->render('pages/user/order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/mes-commandes', name: 'app_order_index')]
    public function index(): Response
    {
        $orders = $this->orderService->getUserOrders($this->getUser());

        return $this->render('pages/user/order/index.html.twig', [
            'orders' => $orders,
        ]);
    }
}
