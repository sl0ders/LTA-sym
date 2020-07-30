<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\AvatarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/signin", name="app_signin")
     * @param AvatarRepository $repository
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Swift_Mailer $mailer
     * @return RedirectResponse|Response
     */
    public function add(AvatarRepository $repository, Request $request, UserPasswordEncoderInterface $passwordEncoder, Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $avatar = $repository->findOneBy(['id' => $_POST['imgProfil']]);
            $em = $this->getDoctrine()->getManager();
            $user->setAvatar($avatar);
            $user->setStatus('visiteur');
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new \DateTime());
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'emails/registration.html.twig',
                        ['user' => $user]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/signin.html.twig', [
            'form' => $form->createView(),
            'avatars' => $repository->findAll()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_edit")
     * @param AvatarRepository $repository
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Swift_Mailer $mailer
     * @param User $user
     * @return RedirectResponse|Response
     */
    public function edit(AvatarRepository $repository, Request $request, UserPasswordEncoderInterface $passwordEncoder, Swift_Mailer $mailer, User $user)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $avatar = $repository->findOneBy(['id' => $_POST['imgProfil']]);
            $em = $this->getDoctrine()->getManager();
            $user->setAvatar($avatar);
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new \DateTime());
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'emails/modification.html.twig',
                        ['user' => $user]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/signin.html.twig', [
            'form' => $form->createView(),
            'avatars' => $repository->findAll()
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
     * @Route("/mailconfirmation/{id}", name="app_confirm")
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function mailConfirmation(User $user, EntityManagerInterface $manager)
    {
        $user->setStatus("Utilisateur");
        $manager->persist($user);
        $manager->flush();
        $this->addFlash("success", "Votre compte a bien été validé.");
        return $this->redirectToRoute("home_user",["name" => $user->getName()]);
    }
}
