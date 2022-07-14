<?php

namespace App\Controller;


use App\Entity\Plugs;
use App\Entity\Station;
use App\Form\PlugsType;
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

}
