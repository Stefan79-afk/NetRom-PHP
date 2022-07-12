<?php

namespace App\Controller;


use App\Entity\Booking;
use App\Entity\Station;
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
use Symfony\Component\Security\Core\Security;

class BookingController extends AbstractController
{
    #[Route('/stations/{location}', name: 'app_stations')]
    public function index(EntityManagerInterface $em, string $location, Security $security): Response
    {
        $repository = $em->getRepository(Station::class);
        $user = $security->getUser();
        $stationData = $repository->findBy(array('address' => $location));
        return $this->render('registration/index.html.twig', [
            'stations' => $stationData,
        ]);
    }
    #[Route('/station/{id}', name:'app_view')]
    public function show(EntityManagerInterface $em, int $id): Response{
        $repository = $em->getRepository(Booking::class);
        $item = $repository->find($id);

        return $this->render('registration/show.html.twig', [
            'item' => $item
        ]);
    }
    #[Route('/', name:'app_default')]
    public function default(): Response{
        return $this->redirectToRoute('app_redirect');
    }
    #[Route('/stations', name: 'app_redirect')]
    public function redirection(Security $security): Response{
        return $this->redirectToRoute('app_stations', ['location' => $security->getUser()->getAddress()]);
    }
}
