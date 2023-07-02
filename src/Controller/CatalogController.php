<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Genre;
use App\Entity\Room;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catalog')]
class CatalogController extends AbstractController
{
    #[Route('/{guid}', name: 'app_catalog')]
    public function index(
        Genre $genre,
        RoomRepository $roomRepository,
    ): Response
    {
        $rooms = [];
        /** @var Animal $animal */
        foreach ($genre->getAnimals() as $animal) {

            if (null === $animal->getRoom()) {
                continue;
            }

         $rooms[$animal->getRoom()?->getCode()] = $animal?->getRoom();
        }
        sort($rooms);
        return $this->render('catalog/index.html.twig', [
            'rooms' => $rooms
        ]);
    }

    #[Route('/show/{guid}', name: 'app_catalog_show')]
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
