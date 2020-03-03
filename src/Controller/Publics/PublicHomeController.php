<?php

namespace App\Controller\Publics;

use App\Entity\User;
use App\Form\Public_UserType;
use App\Repository\AvatarRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicHomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();
        return $this->render('Public/homePublic.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/{name}/mon-profile", name="home_user")
     * @return Response
     */
    public function homeUser()
    {
        $user = $this->getUser();
        return $this->render('Public/user/home.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/{name}/détail-profil", name="user_profile_detail")
     * @return Response
     */
    public function ProfileUser()
    {
        $user = $this->getUser();
        return $this->render('Public/user/show.html.twig', [
            'user' => $user
        ]);
    }


    /**
     * @Route("/{name}/édit-profil", name="public_edit_user")
     * @param User $user
     * @param Request $request
     * @param AvatarRepository $avatarRepository
     * @return Response
     */
    public function editUser(User $user, Request $request, AvatarRepository $avatarRepository)
    {
        $form = $this->createForm(Public_UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (isset($_POST['imgProfil'])) {
                $avatar = $avatarRepository->findOneBy(['id' => $_POST['imgProfil']]);
                $user->setAvatar($avatar);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_profile_detail', ['name' => $user->getName()]);
        }
        return $this->render('Public/user/edit.html.twig', [
            'form' => $form->createView(),
            'avatars' => $avatarRepository->findAll()
        ]);
    }
}
