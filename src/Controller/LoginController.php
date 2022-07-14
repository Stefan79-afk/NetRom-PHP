<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' =>  $lastUsername,
            'error'         => $error
        ]);
    }

    #[Route('/email', name: 'app_email')]
    public function email(Request $request, EntityManagerInterface $entityManager): Response{

        $error = "";
        $data = [];
        $form = $this->createFormBuilder($data)
            ->add('email', TextType::class)
            ->add('submit', SubmitType::class)
            ->getForm()
        ;
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->get('email')->getData();

            $repository = $entityManager->getRepository(User::class);

            $user = $repository->findOneBy(['email' => $data]);

            if(!$user){
                $error="Not Found";

                return $this->redirectToRoute('app_email', [
                    'error' => $error
                ]);
            }

            return $this->redirectToRoute('app_password', [
                'id' => $user->getId()
            ]);
        }

        return $this->renderForm('app/user_verify_email.html.twig', [
            'form'=> $form,
            'error' => $error
        ]);

    }

    #[Route('/password/user={id}', name: 'app_password')]
    public function password(int $id, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response{

        $repository = $entityManager->getRepository(User::class);

        $data = [];
        $form = $this->createFormBuilder($data)
            ->add('password', PasswordType::class)
            ->add('confirmPassword', PasswordType::class)
            ->add('submit', SubmitType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $form->get('password')->getData();
            $passwordConfirmation = $form->get('password')->getData();

            if(strcmp($password, $passwordConfirmation) != 0){
                return $this->redirectToRoute('app_password', [
                    'id' => $id
                ]);
            }

            $user = $repository->find($id);

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $password
                )
            );

            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->renderForm('app/user_change_password.html.twig', [
            'form' => $form,
            'id' => $id
        ]);
    }
}
