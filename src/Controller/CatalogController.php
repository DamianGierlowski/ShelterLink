<?php

namespace App\Controller;

use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catalog')]
class CatalogController extends AbstractController
{
    #[Route('/{guid}', name: 'app_catalog')]
    public function index(
        Room $room,
    ): Response
    {
        return $this->render('catalog/index.html.twig', [
            'controller_name' => 'CatalogController',
            'animals' => $room->getAnimals(),
        ]);
    }

}
