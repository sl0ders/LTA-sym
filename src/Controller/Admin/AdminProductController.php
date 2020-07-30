<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\Stock;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Exception;
use Faker\Provider\Lorem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product")
 */
class AdminProductController extends AbstractController
{
    /**
     * @Route("/", name="admin_product_index", methods={"GET"})
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('Admin/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_product_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pngFile = $form->get('filenamePng')->getData();
            $jpgFile = $form->get('filenameJpg')->getData();
            $pngNewName = self::upload($pngFile);
            $jpgNewName = self::upload($jpgFile);

            $stock = new Stock();
            $stock->setProduct($product);
            $stock->setQuantity($product->getQuantity());
            $stock->setMajAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $product->setUpdatedAt(new \DateTime());
            $product->setFilenameJpg($jpgNewName);
            $product->setFilenamePng($pngNewName);
            $entityManager->persist($product);
            $entityManager->persist($stock);
            $entityManager->flush();

            return $this->redirectToRoute('admin_product_index');
        }

        return $this->render('Admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_product_show", methods={"GET"})
     * @param Product $product
     * @return Response
     */
    public function show(Product $product): Response
    {
        return $this->render('Admin/product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_product_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setFilenamePng($product->getName().".png");
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('admin_product_index');
        }

        return $this->render('Admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_product_delete", methods={"DELETE"})
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_product_index');
    }

    private function upload($fileName) {
        if ($fileName) {

            $originalFilename = pathinfo($fileName->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$fileName->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $fileName->move(
                    $this->getParameter('imgProduct_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                return $e;
            }
            return $newFilename;
        }
    }
}
