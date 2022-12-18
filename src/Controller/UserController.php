<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Cart;
use App\Entity\Product;
use App\Repository\UserRepository;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormTypeInterface;


class UserController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager, ManagerRegistry $registry): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $cart = new Cart();
            $user->setCart($cart);

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setUpdatedAt(new \DateTimeImmutable());

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route(path: '/login', name: 'app_login')]
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

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/profile', name: 'app_users_show', methods: ['GET'])]
    public function show(): Response
    {   
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('profile/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/edit/{id}', name: 'app_users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if($user->getId() !== $this->getUser()->getId()){
            return $this->redirectToRoute('app_users_show');
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_users_show');
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
