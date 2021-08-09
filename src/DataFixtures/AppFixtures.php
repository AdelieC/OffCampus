<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Location;
use App\Entity\Outing;
use App\Entity\Type;
use App\Entity\User;
use DateInterval;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $locationCampus1 = new Location();
        $locationCampus2 = new Location();
        $locationCampus3 = new Location();
        $locationCampus4 = new Location();
        $location1 = new Location();
        $location2 = new Location();
        $location3 = new Location();
        $location4 = new Location();

        $locationCampus1
            ->setCity('SAINT-HERBLAIN')
            ->setZip('44800')
            ->setStreet('rue Benjamin Franklin')
            ->setStreetNb('2B')
            ->setPlace('Campus de Nantes');

        $locationCampus2
            ->setCity('NIORT')
            ->setZip('79000')
            ->setStreet('avenue Léo Lagrange')
            ->setStreetNb('19')
            ->setPlace('Campus de Niort');

        $locationCampus3
            ->setCity('QUIMPER')
            ->setZip('29000')
            ->setStreet('rue Georges Perros')
            ->setStreetNb('19')
            ->setPlace('Campus de Quimper');

        $locationCampus4
            ->setCity('CHARTRES DE BRETAGNE')
            ->setZip('35131')
            ->setStreet('rue Léo Lagrange')
            ->setStreetNb('8')
            ->setPlace('Campus de Rennes');

        $location1
            ->setCity($faker->city())
            ->setZip($faker->postcode())
            ->setStreet($faker->streetName())
            ->setStreetNb($faker->buildingNumber())
            ->setPlace($faker->company());

        $location2
            ->setCity($faker->city())
            ->setZip($faker->postcode())
            ->setStreet($faker->streetName())
            ->setStreetNb($faker->buildingNumber())
            ->setPlace($faker->company());

        $location3
            ->setCity($faker->city())
            ->setZip($faker->postcode())
            ->setStreet($faker->streetName())
            ->setStreetNb($faker->buildingNumber())
            ->setPlace($faker->company());

        $location4
            ->setCity($faker->city())
            ->setZip($faker->postcode())
            ->setStreet($faker->streetName())
            ->setStreetNb($faker->buildingNumber())
            ->setPlace($faker->company());

        $campus1 = new Campus();
        $campus2 = new Campus();
        $campus3 = new Campus();
        $campus4 = new Campus();

        $campus1
            ->setName('Nantes')
            ->setLocation($locationCampus1);

        $campus2
            ->setName('Niort')
            ->setLocation($locationCampus2);

        $campus3
            ->setName('Quimper')
            ->setLocation($locationCampus3);

        $campus4
            ->setName('Rennes')
            ->setLocation($locationCampus4);

        $user1 = new User();
        $user2 = new User();
        $user3 = new User();
        $user4 = new User();
        $user5 = new User();

        $user1
            ->setUserName($faker->firstName())
            ->setTelephone($faker->phoneNumber())
            ->setLastName($faker->lastName())
            ->setFirstName($faker->firstName())
            ->setBirthDate($faker->dateTimeThisCentury())
            ->setEmail($faker->email())
            ->setCampus($campus1)
            ->setPassword(
                $this->encoder->encodePassword(
                $user1,
                'Pa$$w0rd'
                )
            );

        $user2
            ->setUserName($faker->firstName())
            ->setTelephone($faker->phoneNumber())
            ->setLastName($faker->lastName())
            ->setFirstName($faker->firstName())
            ->setBirthDate($faker->dateTimeThisCentury())
            ->setEmail($faker->email())
            ->setCampus($campus2)
            ->setPassword(
                $this->encoder->encodePassword(
                    $user2,
                    'Pa$$w0rd'
                )
            );

        $user3
            ->setUserName($faker->firstName())
            ->setTelephone($faker->phoneNumber())
            ->setLastName($faker->lastName())
            ->setFirstName($faker->firstName())
            ->setBirthDate($faker->dateTimeThisCentury())
            ->setEmail($faker->email())
            ->setCampus($campus1)
            ->setPassword(
                $this->encoder->encodePassword(
                    $user3,
                    'Pa$$w0rd'
                )
            );

        $user4
            ->setUserName($faker->firstName())
            ->setTelephone($faker->phoneNumber())
            ->setLastName($faker->lastName())
            ->setFirstName($faker->firstName())
            ->setBirthDate($faker->dateTimeThisCentury())
            ->setEmail($faker->email())
            ->setCampus($campus3)->setPassword(
                $this->encoder->encodePassword(
                    $user4,
                    'Pa$$w0rd'
                )
            );

        $user5
            ->setUserName($faker->firstName())
            ->setTelephone($faker->phoneNumber())
            ->setLastName($faker->lastName())
            ->setFirstName($faker->firstName())
            ->setBirthDate($faker->dateTimeThisCentury())
            ->setEmail($faker->email())
            ->setCampus($campus1)->setPassword(
                $this->encoder->encodePassword(
                    $user5,
                    'Pa$$w0rd'
                )
            );

        $type1 = new Type();
        $type2 = new Type();
        $type3 = new Type();
        $type4 = new Type();

        $type1->setName('Cinéma');
        $type2->setName('Exposition');
        $type3->setName('Conférence');
        $type4->setName('Sport');

        $outing1 = new Outing();
        $outing2 = new Outing();
        $outing3 = new Outing();
        $outing4 = new Outing();

        $date1 = $faker->dateTimeThisYear();
        $date2 = $faker->dateTimeThisYear();
        $date3 = $faker->dateTimeThisYear();
        $date4 = $faker->dateTimeThisYear();

        $outing1
            ->setLocation($location1)
            ->setCampus($campus1)
            ->setName($faker->sentence(3))
            ->setCreationDate($date1)
            ->setDayAndTime($date1->add(new DateInterval('P10D')))
            ->setClosingDate($date1->add(new DateInterval('P9D')))
            ->setOrganiser($user1)
            ->setCapacity($faker->numberBetween(5, 30))
            ->setFare($faker->numberBetween(0, 30))
            ->setType($type1)
            ->setDescription($faker->sentence(40));

        $outing2
            ->setLocation($location2)
            ->setCampus($campus2)
            ->setName($faker->sentence(3))
            ->setCreationDate($date2)
            ->setDayAndTime($date2->add(new DateInterval('P10D')))
            ->setClosingDate($date2->add(new DateInterval('P9D')))
            ->setOrganiser($user2)
            ->setCapacity($faker->numberBetween(5, 30))
            ->setFare($faker->numberBetween(0, 30))
            ->setType($type2)
            ->setDescription($faker->sentence(40));

        $outing3
            ->setLocation($location3)
            ->setCampus($campus3)
            ->setName($faker->sentence(3))
            ->setCreationDate($date3)
            ->setDayAndTime($date3->add(new DateInterval('P10D')))
            ->setClosingDate($date3->add(new DateInterval('P9D')))
            ->setOrganiser($user3)
            ->setCapacity($faker->numberBetween(5, 30))
            ->setFare($faker->numberBetween(0, 30))
            ->setType($type3)
            ->setDescription($faker->sentence(40));

        $outing4
            ->setLocation($location4)
            ->setCampus($campus1)
            ->setName($faker->sentence(3))
            ->setCreationDate($date4)
            ->setDayAndTime($date4->add(new DateInterval('P10D')))
            ->setClosingDate($date4->add(new DateInterval('P9D')))
            ->setOrganiser($user4)
            ->setCapacity($faker->numberBetween(5, 30))
            ->setFare($faker->numberBetween(0, 30))
            ->setType($type2)
            ->setDescription($faker->sentence(40));

        $manager->persist($locationCampus1);
        $manager->persist($locationCampus1);
        $manager->persist($locationCampus1);
        $manager->persist($locationCampus1);

        $manager->persist($location1);
        $manager->persist($location2);
        $manager->persist($location3);
        $manager->persist($location4);

        $manager->persist($campus1);
        $manager->persist($campus2);
        $manager->persist($campus3);
        $manager->persist($campus4);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->persist($user5);

        $manager->persist($type1);
        $manager->persist($type2);
        $manager->persist($type3);
        $manager->persist($type4);

        $manager->persist($outing1);
        $manager->persist($outing2);
        $manager->persist($outing3);
        $manager->persist($outing4);

        $manager->flush();
    }
}
