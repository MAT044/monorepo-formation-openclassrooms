<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CarController extends AbstractController
{
    public function __construct(
        private readonly CarRepository $carRepository
    ){}

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $cars = $this->carRepository->findAll();
        return $this->render('home.html.twig', [
            'cars' => $cars,
        ]);
    }

    #[Route('/car/{id}', name: 'app_car_show')]
    public function show(Car $car): Response
    {
        return $this->render('car.html.twig', [
            'car' => $car,
        ]);
    }
}
