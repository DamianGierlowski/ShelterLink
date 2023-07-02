<?php

namespace App\Controller\Management;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/management')]
class ManagementController extends AbstractController
{
    #[Route('/', name: 'app_management')]
    public function index(
        GenreRepository $genreRepository,
    ): Response
    {
        return $this->render('home/index.html.twig', [
            'genres' => $genreRepository->findAll(),
        ]);
    }
}
