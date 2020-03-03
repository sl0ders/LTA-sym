<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin_UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/", name="admin_user_index", methods={"GET", "POST"})
     * @param UserRepository $userRepository
     * @param Request $request
     * @return Response
     */
    public function index(UserRepository $userRepository, Request $request): Response
    {
        $formStatus = $this->createForm(Admin_UserType::class);
        $formStatus->handleRequest($request);

        return $this->render('Admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'form' => $formStatus->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_show", methods={"GET","POST"})
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function show(User $user,Request $request): Response
    {
        $formStatus = $this->createForm(Admin_UserType::class, $user);
        $formStatus->handleRequest($request);
        if ($formStatus->isSubmitted() && $formStatus->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("admin_user_index");
        }
        return $this->render('Admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin_user_editStatus")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function editStatus(User $user, Request $request)
    {
        $formStatus = $this->createForm(Admin_UserType::class, $user);
        $formStatus->handleRequest($request);
        return $this->render('Admin/user/edit.html.twig', [
            "form" => $formStatus->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_user_index');
    }
}
