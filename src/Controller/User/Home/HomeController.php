<?php

namespace App\Controller\User\Home;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
final class HomeController extends AbstractController
{
    public function __construct(
        private OrderRepository $orderRepository,
    ) {
    }

    #[Route('/home', name: 'app_user_home', methods: ['GET'])]
    public function index(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $ordersCount = $this->orderRepository->count([
            'user' => $user,
        ]);

        $lastOrders = $this->orderRepository->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC'],
            3
        );

        return $this->render('pages/user/home/index.html.twig', [
            'orders_count' => $ordersCount,
            'last_orders' => $lastOrders,
        ]);
    }
}
