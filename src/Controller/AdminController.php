<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalType;
use App\Form\Import\FileImportType;
use App\Model\CatImportModel;
use App\Repository\AnimalRepository;
use App\Repository\GenreRepository;
use App\Repository\RoomRepository;
use App\Util\FileUploader;
use App\Util\GuidGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/admin')]
#[IsGranted('ROLE_MODERATOR')]
class AdminController extends AbstractController
{

    #[Route('/cat/import', name: 'app_admin_cat_import')]
    public function importCatsAnimals(
        Request $request,
        FileUploader $fileUploader,
        SerializerInterface $serializer,
        AnimalRepository $animalRepository,
        RoomRepository $roomRepository,
        GenreRepository $genreRepository,
        EntityManagerInterface $entityManager,
    )
    {
        $form = $this->createForm(FileImportType::class, );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            $csvData = file_get_contents($file->getPathName());

            $animals = $serializer->deserialize($csvData, CatImportModel::class.'[]', 'csv');
            $genre = $genreRepository->findOneBy(['name' => 'Kot']);
            foreach ($animals as $animal)
            {

                if (null === $animal->getChip() || empty($animal->getChip())) {
                    continue;
                }

             $foundAnimal = $animalRepository->findOneBy(['chip' => $animal->getChip()]);
             if (null === $foundAnimal) {
                 $foundAnimal = new Animal();
                 $foundAnimal
                     ->setGuid(GuidGenerator::generate())
                     ->setChip($animal->getChip())
                 ;
             }

                $cleanName = preg_replace('/^[A-Za-z0-9\s]+(?=\s)/', "", $animal->getName());
                $room = $roomRepository->findOneBy(['code' => trim(preg_replace("/\.\d+/", '', $animal->getRoom()))]);
                if (null === $room) {

                    continue;
                }
                $foundAnimal
                    ->setName($cleanName)
                    ->setRoom($room)
                    ->setColour($animal->getColour())
                    ->setGender("5" == $animal->getGender()? "F" : "M")
                    ->setGenre($genre)
                ;

                $entityManager->persist($foundAnimal);

            }
                $entityManager->flush();



            return $this->redirectToRoute('app_admin_cat_import', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/import.html.twig', [
            'form' => $form,
        ]);
    }
}