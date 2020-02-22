<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin_UserType;
use App\Repository\AvatarRepository;
use App\Repository\UserRepository;
use Exception;
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
     * @Route("/", name="admin_user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('Admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_show", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('Admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @param AvatarRepository $avatarRepository
     * @return Response
     * @throws Exception
     */
    public function edit(Request $request, User $user, AvatarRepository $avatarRepository): Response
    {
        $form = $this->createForm(Admin_UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt(new \DateTime());
            if (isset($_POST['imgProfil'])){
               $avatar =  $avatarRepository->find(['id' => $_POST['imgProfil']]);
                $user->setAvatar($avatar);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
           $em->flush();
            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('Admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'avatars' => $avatarRepository->findAll()
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
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }
}
