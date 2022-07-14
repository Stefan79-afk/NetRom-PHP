<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/account/user={id}', name: 'app_user')]
    public function userInfo(): Response{
        return $this->render('app/user.html.twig');
    }

    #[Route('/account/delete/user={id}', name:'app_user_delete')]
    public function deleteUser(int $id): Response{
        $repository = $this->entityManager->getRepository(User::class);
        $user = $repository->find($id);
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_login');
    }

    #[Route('/account/update/user={id}', name:'app_user_update')]
    public function updateUser(int $id, Request $request): Response{
        $repository = $this->entityManager->getRepository(User::class);
        $user = $repository->find($id);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $userNew = $form->getData();

            $user->setName($userNew->getName());
            $user->setEmail($userNew->getEmail());
            $user->setAddress($userNew->getAddress());

            $this->entityManager->flush();

            return $this->redirectToRoute('app_user', ['id' => $id]);
        }
        return $this->renderForm('app/user_edit.html.twig', [
            'form' => $form
        ]);
    }

    /*
    #[Route('password_change', name: 'app_password_change')]
    public function changePassword(): Response{
        $repository = $this->entityManager->getRepository(User::class);
        $form = $this->createFormBuilder()
            ->add('email')
            ;
    }
    */
}