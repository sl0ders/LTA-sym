<?php

namespace App\Controller\Publics;
use App\Repository\ProductRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicHomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ProductRepository $productRepository
     * @param CartService $cartService
     * @return Response
     */
    public function index(ProductRepository $productRepository, CartService $cartService)
    {
        $products = $productRepository->findAll();
        return $this->render('Public/homePublic.html.twig',[
            'products' => $products
        ]);
    }
}
