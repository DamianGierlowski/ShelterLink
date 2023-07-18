<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Entity\Genre;
use App\Entity\Room;
use App\Model\AnimalImportModel;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_WORKER')]
class ManagementController extends AbstractDashboardController
{
    #[Route('/management', name: 'app_management')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ShelterLink')
            ->setTranslationDomain('messages')
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('admin.back', 'fa fa-home','app_home');
        yield MenuItem::linkToCrud('admin.genre.title', 'fas fa-list', Genre::class);
        yield MenuItem::linkToCrud('admin.room.title', 'fas fa-list', Room::class);
        yield MenuItem::linkToCrud('admin.animal.title', 'fas fa-list', Animal::class);
    }
}
