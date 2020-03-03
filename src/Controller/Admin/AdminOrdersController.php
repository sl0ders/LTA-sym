<?php

namespace App\Controller\Admin;

use App\Entity\Orders;
use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/orders")
 */
class AdminOrdersController extends AbstractController
{
    /**
     * @Route("/", name="admin_orders_index", methods={"GET"})
     * @param OrdersRepository $ordersRepository
     * @return Response
     */
    public function index(OrdersRepository $ordersRepository): Response
    {
        return $this->render('Admin/orders/index.html.twig', [
            'orders' => $ordersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_orders_show", methods={"GET"})
     * @param Orders $order
     * @return Response
     */
    public function show(Orders $order): Response
    {
        return $this->render('Admin/orders/show.html.twig', [
            'order' => $order,
        ]);
    }


    /**
     * @Route("/{id}", name="admin_orders_delete", methods={"DELETE"})
     * @param Request $request
     * @param Orders $order
     * @return Response
     */
    public function delete(Request $request, Orders $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_orders_index');
    }
}
