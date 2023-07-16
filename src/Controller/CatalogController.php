<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Genre;
use App\Entity\Room;
use App\Repository\RoomRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catalog')]
class CatalogController extends AbstractController
{
    #[Route('/{guid}', name: 'app_catalog')]
    public function index(
        Genre $genre,
    ): Response
    {
        $rooms = [];
        /** @var Animal $animal */
        foreach ($genre->getAnimals() as $animal) {

            if (null === $animal->getRoom()) {
                continue;
            }

            if (null === $animal->getRoom()->getCode() ) {
                continue;
            }
         $rooms[$animal->getRoom()->getCode()] = $animal?->getRoom();
        }
        sort($rooms);

        return $this->render('catalog/index.html.twig', [
            'rooms' => $rooms,
            'genre' => $genre,
        ]);
    }

    #[Route('/{genreGuid}/show/{guid}', name: 'app_catalog_show')]
    #[ParamConverter('genre', options: ['mapping' => ['genreGuid' => 'guid']])]
    public function show(
        Genre $genre,
        Room $room,
    ): Response
    {
        return $this->render('catalog/show.html.twig', [
            'animals' => $room->getAnimals(),
            'room' => $room,
            'genre' => $genre
        ]);
    }

}
