<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Enum\Motor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cars = [
            [
                'name' => 'Renault Twingo',
                'description' => 'Petite citadine agile idéale pour la ville et les trajets courts.',
                'dailyPrice' => '39.14',
                'monthlyPrice' => '900.00',
                'motor' => Motor::MANUAL,
                'places' => 4,
            ],
            [
                'name' => 'Renault Clio',
                'description' => 'Berline compacte confortable, parfaite pour un usage quotidien.',
                'dailyPrice' => '38.64',
                'monthlyPrice' => '850.00',
                'motor' => Motor::MANUAL,
                'places' => 4,
            ],
            [
                'name' => 'BMW IX (Electric)',
                'description' => 'SUV électrique premium avec une conduite douce et silencieuse.',
                'dailyPrice' => '42.40',
                'monthlyPrice' => '950.00',
                'motor' => Motor::AUTO,
                'places' => 4,
            ],
            [
                'name' => 'Renault Zoé',
                'description' => 'Voiture électrique citadine, économique et agréable à conduire.',
                'dailyPrice' => '39.14',
                'monthlyPrice' => '900.00',
                'motor' => Motor::AUTO,
                'places' => 4,
            ],
            [
                'name' => 'Citroën Ami',
                'description' => 'Modèle urbain compact, pratique pour les déplacements très réguliers.',
                'dailyPrice' => '28.59',
                'monthlyPrice' => '799.00',
                'motor' => Motor::AUTO,
                'places' => 4,
            ],
            [
                'name' => 'Opel Corsa',
                'description' => 'Voiture polyvalente avec un bon compromis entre confort et efficacité.',
                'dailyPrice' => '36.38',
                'monthlyPrice' => '820.00',
                'motor' => Motor::MANUAL,
                'places' => 4,
            ],
        ];

        foreach ($cars as $carData) {
            $car = new Car();
            $car->setName($carData['name'])
                ->setDescription($carData['description'])
                ->setDailyPrice($carData['dailyPrice'])
                ->setMonthlyPrice($carData['monthlyPrice'])
                ->setMotor($carData['motor'])
                ->setPlaces($carData['places']);

            $manager->persist($car);
        }

        $manager->flush();
    }
}
