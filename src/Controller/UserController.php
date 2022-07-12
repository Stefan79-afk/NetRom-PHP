<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/account/user={id}', name: 'app_user')]
    public function userInfo(): Response{
        return $this->render('app/user.html.twig');
    }

    #[Route('/account/delete/user={id}', name:'app_user_delete')]
    public function  deleteUser(int $id, EntityManagerInterface $em): Response{
        $repository = $em->getRepository(User::class);
        $user = $repository->find($id);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_login');
    }
}