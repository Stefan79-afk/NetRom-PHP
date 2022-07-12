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
    #[Route('/stations/{location}', name: 'app_stations')]
    public function index(EntityManagerInterface $em, string $location, Security $security): Response
    {
        $repository = $em->getRepository(Station::class);
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
    public function redirection(Security $security): Response{

        return $this->redirectToRoute('app_stations', ['location' => $security->getUser()->getAddress()]);
    }

}
