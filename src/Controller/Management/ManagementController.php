<?php

namespace App\Controller\Management;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/management')]
#[IsGranted('ROLE_WORKER')]
class ManagementController extends AbstractController
{
    #[Route('/', name: 'app_management')]
    public function index(
    ): Response
    {
        return $this->render('management/index.html.twig');
    }
}
