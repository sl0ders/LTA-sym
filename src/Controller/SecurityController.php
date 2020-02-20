<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignInType;
use App\Form\UserType;
use App\Repository\AvatarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 * @Route("/user")
 */
class SecurityController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/", name="public_user_show")
     * @return Response
     */
    public function show()
    {
        return $this->render('Public/user/show.html.twig');
    }

    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/sign-in", name="app_signin")
     * @param Request $request
     * @param AvatarRepository $repository
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function new(Request $request, AvatarRepository $repository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $avatars = $repository->findAll();
        $user = new User;
        $user->getAvatar();
        $form = $this->createForm(SignInType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $avatar = $repository->findOneBy(['id' => $_POST["imgProfil"]]);
            $user->setAvatar($avatar);
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_USER']);
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute("app_login");
        }
        return $this->render("security/signin.html.twig", [
            'form' => $form->createView(),
            'avatars' => $avatars
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     * @throws Exception
     */
    public function logout()
    {
        throw new Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/edit/{id}", name="public_edit_user", methods={"GET","POST"})
     * @param $user
     * @param Request $request
     * @param AvatarRepository $repository
     * @return Response
     */
    public function edit(Request $request, User $user, AvatarRepository $repository): Response
    {
        $avatars = $repository->findAll();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if(isset($_POST['imgProfil'])){
                $avatar = $repository->findOneBy(['id' => $_POST["imgProfil"]]);
                $user->setAvatar($avatar);
            }
            $user->setAvatar($user->getAvatar());
            $user->setPassword($user->getPassword());
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('public_user_show');
        }

        return $this->render('Public/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'avatars' => $avatars
        ]);
    }
}
