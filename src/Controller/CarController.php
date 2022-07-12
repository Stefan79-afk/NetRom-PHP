<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/cars/user={id}', name:'app_cars_view')]
    public function show(EntityManagerInterface $em, int $id): Response{
        $repository = $em->getRepository(User::class);
        $user = $repository->find($id);
        $cars = $user->getCars();
        return $this->render('app/show.html.twig', [
            'cars' => $cars
        ]);
    }

    #[Route('cars/user={id}/delete_car={carId}', name: 'app_cars_delete')]
    public function delete(EntityManagerInterface $em, int $id, int $carId): Response{
        $repository = $em->getRepository(Car::class);
        $car = $repository->find($carId);
        $em->remove($car);
        $em->flush();

        return $this->redirectToRoute('app_cars_view', ['id' => $id]);
    }
}