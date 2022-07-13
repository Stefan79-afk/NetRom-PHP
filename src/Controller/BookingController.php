<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Car;
use App\Entity\Plugs;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class BookingController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/bookings/user={id}', name: 'app_bookings_show')]
    public function show(int $id): Response{
        $user = $this->security->getUser();
        //$carRepository = $this->entityManager->getRepository(Car::class);
        $bookingRepository = $this->entityManager->getRepository(Booking::class);

        $cars = $user->getCars();
        $bookings = array();


        foreach ($cars as $index => $value){
            $bookings[] = $bookingRepository->findBy(array('carId' => $value->getId()));
        }


        return $this->render('app/bookings_show.html.twig', [
            'bookings' => $bookings
        ]);
    }

    #[Route('/bookings/user={id}/delete_booking={bookingId}', name: 'app_bookings_delete')]
    public function delete(int $id, int $bookingId): Response{
        $repository =$this->entityManager->getRepository(Booking::class);
        $booking = $repository->find($bookingId);

        $this->entityManager->remove($booking);
        $this->entityManager->flush();
        return $this->redirectToRoute("app_bookings_show", [
            'id' => $id
        ]);

    }

}