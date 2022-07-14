<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Car;
use App\Entity\Plugs;
use App\Entity\User;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /*
    #[Route('bookings/user={id}/update_booking={bookingId}', name: 'app_bookings_update')]
    public function update(int $id, int $bookingId, Request $request): Response{
        $repository = $this->entityManager->getRepository(Booking::class);
        $booking = $repository->find($bookingId);
        $form = $this->createForm(BookingType::class, $booking);
        $error = '';
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $bookingNew = $form->getData();

            $station = $bookingNew->getPlugId();

            $plugs = $station->getPlugs();
            $plugId = 0;
            foreach ($plugs as $plug){
                if($plug->getType() == $bookingNew->getCarId()->getPlugType() && $plug->getStatus() == 'Ready'){
                    $error = null;
                    $plugId = $plug->getId();
                    break;
                }
            }

            if($error == null){
                $booking->setDuration($bookingNew->getDuration());
                $booking->setStartTime($bookingNew->getStartTime());
                $booking->setCarId($bookingNew->getCarId());
                $booking->setPlugId($plugId);

                $this->entityManager->flush();

                return $this->redirectToRoute('app_bookings_show', ['id' => $id]);
            }

            else{
                $error = 'No Plug';
                return $this->redirectToRoute('app_bookings_update', [
                    'id' => $id,
                    'bookindId' => $bookingId
                ]);
            }

        }

        return $this->renderForm('app/bookings_edit.html.twig', [
            'form' => $form,
            'booking' => $booking->getId(),
            'error' => $error
        ]);
    }
    */

}