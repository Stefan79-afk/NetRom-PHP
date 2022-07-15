<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Car;
use App\Entity\Plugs;
use App\Entity\Station;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class BookingType extends AbstractType
{
    private Security $security;
    private EntityManagerInterface $entityManager;
    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $carsInfo = $user->getCars();

        $carsArr = array();

        foreach($carsInfo as $value){
            $carsArr[$value->getPlate()] = $value->getId();
        }

        $repository = $this->entityManager->getRepository(Station::class);
        $stations = $repository->findBy(['address' => $user->getAddress()]);

        $stationsArr = array();

        foreach ($stations as $value){
            $stationsArr[$value->getLocation()] = $value->getId();
        }

        $builder
            ->add('duration')
            ->add('startTime', DateTimeType::class)
            ->add('carId')
            ->add('plugId')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
