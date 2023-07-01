<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Form\Admin\AnimalImportType;
use App\Service\Admin\ImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class ImportController extends AbstractController
{

    #[Route('/import', name: 'app_admin_import')]
    public function import(
        Request $request,
        ImportService $importService,
    )
    {
        $form = $this->createForm(AnimalImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $importService->handleImportForm($form);

            return $this->redirectToRoute('app_admin_cat_import', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/import.html.twig', [
            'form' => $form,
        ]);
    }



}