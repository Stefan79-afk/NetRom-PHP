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

    #[Route('registration/{id}', name:'app_view')]
    public function show(EntityManagerInterface $em, int $id): Response{
        $repository = $em->getRepository(Booking::class);
        $item = $repository->find($id);

        return $this->render('registration/show.html.twig', [
            'item' => $item
        ]);
    }

    #[Route('/create', name:'app_create')]
    public function create(EntityManagerInterface $em, Request $request): Response{
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $booking = $form->getData();
            dd($booking);
            /*
            $em->persist($booking);

            $em->flush();

            $this->redirectToRoute('app_registration');
            */
        }
        return $this->renderForm('registration/create.html.twig', [
            'form' => $form
        ]);
    }

}
