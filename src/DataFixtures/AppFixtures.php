<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\Plugs;
use App\Entity\Station;
use App\Entity\User;
use App\Entity\Car;
use Cassandra\Time;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\UserLogin;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $time = new \DateTime();
        //Users
        $user1 = new User();
        $user1->setName("John Smith");
        $user1->setEmail("john.smith@gmail.com");
        $user1->setPassword($this->passwordHasher->hashPassword(
            $user1,
            "password"
        ));
        $user1->setRoles(['ROLE_USER']);
        $user1->setAddress("Bucharest, Romania");

        $user2 = new User();
        $user2->setName("Steven Nathan");
        $user2->setEmail("steve.nathan@gmail.com");
        $user2->setPassword($this->passwordHasher->hashPassword(
            $user2,
            "randomPassword12("
        ));
        $user2->setRoles(['ROLE_USER']);
        $user2->setAddress("Cluj-Napoca, Romania");

        $user3 = new User();
        $user3->setName("Kelly Williams");
        $user3->setEmail("kelly.williams@gmail.com");
        $user3->setPassword($this->passwordHasher->hashPassword(
            $user3,
            "qwdfvbhjio90"
        ));
        $user3->setRoles(['ROLE_USER']);
        $user3->setAddress("Timisoara, Romania");

        $user4 = new User();
        $user4->setName("Ashley Chambers");
        $user4->setEmail("ash.chambers@gmail.com");
        $user4->setPassword( $this->passwordHasher->hashPassword(
            $user4,
            "asjknakln29381%^$^ "
        ));
        $user4->setRoles(['ROLE_USER']);
        $user4->setAddress("Oradea, Romania");

        $user5 = new User();
        $user5->setName("Phill Jackson");
        $user5->setEmail("phill.jack@gmail.com");
        $user5->setPassword($this->passwordHasher->hashPassword(
            $user5,
            "akksnkjalsngla153*$(*$"
        ));
        $user5->setRoles(['ROLE_USER']);
        $user5->setAddress("Craiova, Romania");

        //Cars
        $car1 = new Car();
        $car1->setPlate("TM-23-LEZ");
        $car1->setPlugType("Type 1");

        $car2 = new Car();
        $car2->setPlate("TM-36-CNZ");
        $car2->setPlugType("Type 2");

        $car3 = new Car();
        $car3->setPlate("CS-47-MNO");
        $car3->setPlugType("Type 2");

        $car4 = new Car();
        $car4->setPlate("B-13-MHQ");
        $car4->setPlugType("Type 2");

        $car5 = new Car();
        $car5->setPlate("CJ-09-SMH");
        $car5->setPlugType("Type 1");

        $car6 = new Car();
        $car6->setPlate("AR-18-GLQ");
        $car6->setPlugType("Type 1");

        $car7 = new Car();
        $car7->setPlate("VL-55-LOP");
        $car7->setPlugType("Type 2");

        $car8 = new Car();
        $car8->setPlate("TM-84-GBR");
        $car8->setPlugType("Type 1");

        $car9 = new Car();
        $car9->setPlate("TM-41-THD");
        $car9->setPlugType("Type 2");

        //Adding cars to users
        $user1->addCar($car1);
        $user1->addCar($car2);

        $user2->addCar($car3);

        $user3->addCar($car4);
        $user3->addCar($car5);

        $user4->addCar($car6);

        $user5->addCar($car7);
        $user5->addCar($car8);
        $user5->addCar($car9);


        //Stations
        $station1 = new Station();
        $station1->setName("Circumvalatiunii Station 1");
        $station1->setLocation("Strada Circumvalatiunii");
        $station1->setAddress("Timisoara, Romania");

        $station2 = new Station();
        $station2->setName("Centru Station 1");
        $station2->setLocation("Bulevardul Michel Angelo");
        $station2->setAddress("Craiova, Romania");

        $station3 = new Station();
        $station3->setName("Calea Aradului Station 1");
        $station3->setLocation("Calea Aradului nr. 42");
        $station3->setAddress("Cluj-Napoca, Romania");

        $station4 = new Station();
        $station4->setName("Circumvalatiunii Station 2");
        $station4->setLocation("Strada Circumvalatiunii");
        $station4->setAddress("Oradea, Romania");

        $station5 = new Station();
        $station5->setName("Centru Station 2");
        $station5->setLocation("Bulevardul 1 Decembrie");
        $station5->setAddress("Bucharest, Romania");

        //Plugs
        $plug1 = new Plugs();
        $plug1->setStatus("Ready");
        $plug1->setType("Type 1");


        $plug2 = new Plugs();
        $plug2->setStatus("Ready");
        $plug2->setType("Type 2");

        $plug3 = new Plugs();
        $plug3->setStatus("Busy");
        $plug3->setType("Type 1");


        $plug4 = new Plugs();
        $plug4->setStatus("In Maintenance");
        $plug4->setType("Type 2");


        $plug5 = new Plugs();
        $plug5->setStatus("Temporarily Unavailable");
        $plug5->setType("Type 1");


        //Station and Plug
        /*
        $plug1->setStation($station1);
        $plug1->setStation($station3);

        $plug2->setStation($station1);
        $plug2->setStation($station5);
        $plug2->setStation($station3);

        $plug3->setStation($station2);
        $plug3->setStation($station4);

        $plug4->setStation($station3);
        $plug4->setStation($station2);
        $plug4->setStation($station5);

        $plug5->setStation($station4);
        $plug5->setStation($station5);
        $plug5->setstation($station1);
        $plug5->setStation($station2);
        $plug5->setStation($station3);
        */
        $station1->addPlug($plug1);
        $station1->addPlug($plug2);
        $station1->addPlug($plug5);

        $station2->addPlug($plug3);
        $station2->addPlug($plug4);
        $station2->addPlug($plug5);

        $station3->addPlug($plug1);
        $station3->addPlug($plug2);
        $station3->addPlug($plug4);
        $station3->addPlug($plug5);

        $station4->addPlug($plug3);
        $station4->addPlug($plug5);

        $station5->addPlug($plug2);
        $station5->addPlug($plug4);
        $station5->addPlug($plug5);

        //Booking
        $booking1 = new Booking();
        $booking1->setStartTime($time);
        $booking1->setDuration(90);
        $booking1->setCarId($car1);
        $booking1->setPlugId($plug1);

        $booking2 = new Booking();
        $booking2->setStartTime($time);
        $booking2->setDuration(120);
        $booking2->setCarId($car6);
        $booking2->setPlugId($plug3);

        $booking3 = new Booking();
        $booking3->setStartTime($time);
        $booking3->setDuration(30);
        $booking3->setCarId($car9);
        $booking3->setPlugId($plug2);

        //UserLogin

        //Persists
        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->persist($user5);


        $manager->persist($car1);
        $manager->persist($car2);
        $manager->persist($car3);
        $manager->persist($car4);
        $manager->persist($car5);
        $manager->persist($car6);
        $manager->persist($car7);
        $manager->persist($car8);
        $manager->persist($car9);

        $manager->persist($station1);
        $manager->persist($station2);
        $manager->persist($station3);
        $manager->persist($station4);
        $manager->persist($station5);

        $manager->persist($plug1);
        $manager->persist($plug2);
        $manager->persist($plug3);
        $manager->persist($plug4);
        $manager->persist($plug5);

        $manager->persist($booking1);
        $manager->persist($booking2);
        $manager->persist($booking3);

        //Flush
        $manager->flush();


    }
}