<?php

namespace App\Controller\Admin;

use App\Entity\Stock;
use App\Form\StockCollectionType;
use App\Form\StockType;
use App\Repository\StockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/stock")
 */
class AdminStockController extends AbstractController
{
    /**
     * @Route("/", name="admin_stock_index", methods={"GET","POST"})
     * @param StockRepository $stockRepository
     * @param Request $request
     * @return Response
     */
    public function index(StockRepository $stockRepository, Request $request): Response
    {
        $form = $this->createForm(StockType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_stock_index');
        }
        return $this->render('Admin/stock/index.html.twig', [
            'stocks' => $stockRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_stock_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Stock $stock
     * @return Response
     */
    public function edit(Request $request, Stock $stock): Response
    {
        $form = $this->createForm(StockCollectionType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_stock_index');
        }
        return $this->redirectToRoute('admin_stock_index');
    }

    /**
     * @Route("/{id}", name="admin_stock_delete", methods={"DELETE"})
     * @param Request $request
     * @param Stock $stock
     * @return Response
     */
    public function delete(Request $request, Stock $stock): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stock->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_stock_index');
    }
}
