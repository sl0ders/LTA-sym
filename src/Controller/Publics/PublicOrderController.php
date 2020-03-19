<?php


namespace App\Controller\Publics;

use App\Entity\Orders;
use App\Repository\OrdersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class PublicOrderController
 * @package App\Controller\Publics
 * @Route("/commande")
 */
class PublicOrderController extends AbstractController
{
    /**
     * @Route("/{name}", name="user_orders")
     * @param OrdersRepository $repository
     * @return Response
     */
    public function ordersUser(OrdersRepository $repository)
    {
        $orders = $repository->findAll();
        return $this->render('Public/orders/index.html.twig',[
            "orders" => $orders
        ]);
    }

    /**
     * @Route("/detail-commande/{id}", name="order_show")
     * @param Orders $order
     * @return Response
     */
    public function orderShow(Orders $order)
    {
        return $this->render('Public/orders/show.html.twig', [
            'order' => $order
        ]);
    }
    /**
     * @Route("/{id}", name="public_orders_changeValid")
     * @param Request $request
     * @param Orders $order
     * @return Response
     */
    public function delete(Request $request, Orders $order): Response
    {
        if ($this->isCsrfTokenValid('changeValid'.$order->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $order->setValidation(5);
            $em->flush();
        }
        return $this->redirectToRoute('user_orders', ['name' => $this->getUser()->getFirstname()]);
    }
}