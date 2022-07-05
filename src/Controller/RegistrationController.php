<?php

namespace App\Controller;


use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Booking::class);
        $bookingData = $repository->findAll();


        return $this->render('registration/index.html.twig', [
            'registration' => $bookingData,
        ]);
    }

}
