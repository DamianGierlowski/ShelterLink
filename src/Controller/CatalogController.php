<?php

namespace App\Controller;

use App\Entity\Room;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catalog')]
class CatalogController extends AbstractController
{
    #[Route('/', name: 'app_catalog')]
    public function index(
        RoomRepository $roomRepository,
    ): Response
    {
        return $this->render('room/index.html.twig', [
            'rooms' => $roomRepository->findAll(),
        ]);
    }

    #[Route('/{guid}', name: 'app_catalog_show')]
    public function show(
        Room $room,
    ): Response
    {
        return $this->render('catalog/show.html.twig', [
            'animals' => $room->getAnimals(),
            'room' => $room,
        ]);
    }

}
