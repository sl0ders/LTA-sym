<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LayoutBundleController extends AbstractController
{
    public function leftMenuAction(CartService $cartService)
    {
        $total = $cartService->getTotal();
        return $this->render('Layout/_sidebar_left.html.twig', [
            'cartTotal' => $total
        ]);
    }
    public function rightMenuAction(NewsRepository $repository)
    {
        return $this->render('Layout/_sidebar_right.html.twig', [
            'news' => $repository->findAll()
        ]);
    }
}
