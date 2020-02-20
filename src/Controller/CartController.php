<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Service\Cart\CartService;
use DateTime;
use Exception;
use http\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CartController
 * @package App\Controller
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @var CartService
     */
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/", name="cart_index")
     */
    public function index()
    {
        return $this->render('Public/cart/index.html.twig', [
            'cartProducts' => $this->cartService->getAllCart(),
            'total' => $this->cartService->getTotal()
        ]);
    }

    /**
     * @Route("/add/{id}",name="cart_add")
     * @param $id
     * @return RedirectResponse
     */
    public function add($id)
    {
        $quantity = $_POST["quantity"];
        $this->cartService->add($id, $quantity);
        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/remove/{id}", name="cart_remove")
     * @param $id
     * @return RedirectResponse
     */
    public function refresh($id)
    {
        $quantity = $_POST["quantity"];
        $this->cartService->refresh($id, $quantity);
        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/valid", name="cart_valid")
     * @return RedirectResponse
     * @throws Exception
     */
    public function validCart()
    {
        $em = $this->getDoctrine()->getManager();
        $carts = $this->cartService->getAllCart();
        foreach ($carts as $cart) {
            $order = new Orders();
            $order
                ->setCreatedAt(new DateTime())
                ->setNCmd($this->getUser()->getUsername().'-'.date("Y-d-m-i-s"))
                ->setQuantity($cart['quantity'])
                ->setUsers($this->getUser())
                ->setProducts($cart['product'])
                ->setTotal(intval($this->cartService->getTotal()))
                ->setValidation(1);
            $em->persist($order);
        }
        $em->flush();

        $this->get('session')->remove('cart');
        return $this->redirectToRoute("home");
    }
}
