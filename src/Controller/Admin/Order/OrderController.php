<?php

namespace App\Controller\Admin\Order;

use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/commandes')]
#[IsGranted('ROLE_ADMIN')]
class OrderController extends AbstractController
{
    #[Route('', name: 'app_admin_order_index')]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('pages/admin/order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_order_show')]
    public function show(int $id, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find($id);

        if (!$order) {
            throw $this->createNotFoundException('Commande non trouvée.');
        }

        return $this->render('pages/admin/order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}/statut', name: 'app_admin_order_status', methods: ['POST'])]
    public function updateStatus(int $id, Request $request, OrderRepository $orderRepository, EntityManagerInterface $em): Response
    {
        $order = $orderRepository->find($id);

        if (!$order) {
            throw $this->createNotFoundException('Commande non trouvée.');
        }

        $status = $request->request->get('status');
        $allowedStatuses = ['PENDING', 'PAID', 'SHIPPED', 'CANCELLED'];

        if (in_array($status, $allowedStatuses)) {
            $order->setStatus($status);
            $em->flush();
            $this->addFlash('success', 'Statut mis à jour.');
        }

        return $this->redirectToRoute('app_admin_order_show', ['id' => $order->getId()]);
    }
}
