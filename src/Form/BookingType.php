<?php

namespace App\Form;

use App\Entity\Booking;
//use App\Entity\Car;
use App\Entity\Car;
use App\Entity\Plugs;
//use Doctrine\DBAL\Types\DateTimeType;
//use Doctrine\DBAL\Types\IntegerType;
//use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;


class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duration', IntegerType::class)
            ->add('startTime', DateTimeType::class)
            ->add('carId',EntityType::class, [
                'class' => Car::class
            ])
            ->add('plugId', EntityType::class, [
                'class' => Plugs::class
            ])
            ->add('Create', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
