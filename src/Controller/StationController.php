<?php

namespace App\Controller;


use App\Entity\Booking;
use App\Entity\Plugs;
use App\Entity\Station;
use App\Form\PlugsType;
use App\Form\StationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/stations/station={id}', name:'app_stations_details')]
    public function details(int $id): Response{

        $repository = $this->entityManager->getRepository(Station::class);
        $repository2 = $this->entityManager->getRepository(Plugs::class);
        $station = $repository->find($id);
        $plugs = $repository2->findBy(['station' => $station->getId()]);


        return $this->render('app/stations_detail.html.twig', [
            'station' => $station,
            'plugs' => $plugs
        ]);

    }

    #[Route('/stations/station={id}/delete_plug={plugId}', name: 'app_station_delete_plug')]
    public function deletePlug(int $id, int $plugId): Response{
        $repository = $this->entityManager->getRepository(Plugs::class);

        $plug = $repository->find($plugId);

        $this->entityManager->remove($plug);

        $this->entityManager->flush();
        return $this->redirectToRoute('app_stations_details', [
            'id' => $id
        ]);
    }

    #[Route('/stations/station={id}/edit_plug={plugId}', name:'app_plugs_edit')]
    public function updatePlug(int $id, int $plugId, Request $request): Response{
        $repository = $this->entityManager->getRepository(Plugs::class);

        $plug = $repository->find($plugId);

        $station = $plug->getStation();
        $form = $this->createForm(PlugsType::class, $plug);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $plug->setType($form->get('type')->getData());
            $plug->setStatus($form->get('status')->getData());

            $this->entityManager->flush();

            return $this->redirectToRoute('app_stations_details', [
                'id' => $id
            ]);
        }

        return $this->renderForm('app/plugs_edit.html.twig', [
            'form' => $form,
            'station' => $station
        ]);

    }

    #[Route('/stations/station={id}/create_plug', name: "app_plugs_create")]
    public function createPlug(int $id, Request $request): Response{

        $repository = $this->entityManager->getRepository(Station::class);

        $station = $repository->find($id);
        $plug = new Plugs();

        $form = $this->createForm(PlugsType::class, $plug);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $station->addPlug($plug);

            $this->entityManager->persist($plug);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_stations_details', [
                'id' => $id
            ]);
        }

        return $this->renderForm('app/plugs_create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('stations/delete={id}', name: 'app_station_delete')]
    public function deleteStation(int $id): Response{
        $repository = $this->entityManager->getRepository(Station::class);
        $repository2 = $this->entityManager->getRepository(Booking::class);
        $station = $repository->find($id);

        $plugs = $station->getPlugs();

        foreach ($plugs as $plug){
            $bookings = $repository2->findBy(['plugId' => $plug->getId()]);

            foreach ($bookings as $booking){
                $this->entityManager->remove($booking);
            }

            $this->entityManager->remove($plug);
        }

        $this->entityManager->remove($station);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_stations', [
            'location' => $station->getAddress()
        ]);
    }

    #[Route('/stations/create', name: 'app_station_create')]
    public function createStation(Request $request): Response{
        $station = new Station();
        $form = $this->createForm(StationType::class, $station);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($station);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_stations', [
                'location' => $station->getAddress()
            ]);
        }

        return $this->renderForm('app/station_create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/stations/update={id}', name: 'app_station_create')]
    public function updateStation(int $id, Request $request): Response{
        $repository = $this->entityManager->getRepository(Station::class);

        $station = $repository->find($id);
        $form = $this->createForm(StationType::class, $station);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->entityManager->flush();

            return $this->redirectToRoute('app_stations_details', [
                'id' => $id
            ]);
        }

        return $this->renderForm('app/station_create.html.twig', [
            'form' => $form,
            'id' => $id
        ]);
    }


}
