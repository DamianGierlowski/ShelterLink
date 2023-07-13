<?php

namespace App\Controller\Management;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use App\Util\FileUploader;
use App\Util\GuidGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/genre')]
#[IsGranted('ROLE_WORKER')]
class GenreController extends AbstractController
{

    #[Route('/', name: 'app_genre_index', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        GenreRepository $genreRepository,
        FileUploader $fileUploader,
    ): Response {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid())  {
            $file = $form->get('file')->getData();

            if (null !== $file) {

                $path =  $this->getParameter('archive');

                $uploaded = $fileUploader->upload($file, $path);
                $genre->setFile($uploaded);
            }

            $genre->setGuid(GuidGenerator::generate());
            $genreRepository->save($genre, true);

            return $this->redirectToRoute('app_genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('genre/index.html.twig', [
            'genre' => $genre,
            'form' => $form,
            'genres' => $genreRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_genre_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Genre $genre,
        GenreRepository $genreRepository,
        FileUploader $fileUploader,
    ): Response {
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            if (null !== $file) {
                $path = $this->getParameter('archive');
                $uploaded = $fileUploader->upload($file, $path);
                $genre->setFile($uploaded);
            }

            $genreRepository->save($genre, true);

            return $this->redirectToRoute('app_genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('genre/index.html.twig', [
            'genre' => $genre,
            'form' => $form,
            'genres' => $genreRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_genre_delete', methods: ['GET'])]
    public function delete(Genre $genre, GenreRepository $genreRepository): Response
    {
            $genreRepository->remove($genre, true);

        return $this->redirectToRoute('app_genre_index', [], Response::HTTP_SEE_OTHER);
    }
}
