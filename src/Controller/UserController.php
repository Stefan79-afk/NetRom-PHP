<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Station;
use App\Entity\User;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    #[Route('/account/user={id}', name: 'app_user')]
    public function userInfo(int $id): Response{
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