<?php

namespace App\Controller;


use App\Entity\Booking;
use App\Entity\User;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/bookings', name: 'app_registration')]
    public function index(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Booking::class);
        $bookingData = $repository->findAll();


        return $this->render('registration/index.html.twig', [
            'registration' => $bookingData,
        ]);
    }
    #[Route('booking/{id}', name:'app_view')]
    public function show(EntityManagerInterface $em, int $id): Response{
        $repository = $em->getRepository(Booking::class);
        $item = $repository->find($id);

        return $this->render('registration/show.html.twig', [
            'item' => $item
        ]);
    }
}
