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

class CarController extends AbstractController
{
    #[Route('/cars/user={id}', name:'app_view')]
    public function show(EntityManagerInterface $em, int $id): Response{
        $repository = $em->getRepository(User::class);
        $user = $repository->find($id);
        $cars = $user->getCars();
        return $this->render('app/show.html.twig', [
            'cars' => $cars
        ]);
    }
}