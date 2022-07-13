<?php

namespace App\Controller;


use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class StationController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/stations/{location}', name: 'app_stations')]
    public function index(string $location): Response
    {
        $repository = $this->entityManager->getRepository(Station::class);
        $stationData = $repository->findBy(array('address' => $location));
        return $this->render('app/index.html.twig', [
            'stations' => $stationData,
        ]);
    }
    #[Route('/', name:'app_default')]
    public function default(): Response{
        return $this->redirectToRoute('app_redirect');
    }
    #[Route('/stations', name: 'app_redirect')]
    public function redirection(): Response{

        return $this->redirectToRoute('app_stations', ['location' => $this->security->getUser()->getAddress()]);
    }

}
