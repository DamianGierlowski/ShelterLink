<?php

namespace App\Service\Admin;

use App\Entity\Animal;
use App\Model\AnimalImportModel;
use App\Repository\AnimalRepository;
use App\Repository\GenreRepository;
use App\Repository\RoomRepository;
use App\Util\GuidGenerator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ImportService
{

    public function __construct(
        private readonly AnimalRepository    $animalRepository,
        private readonly RoomRepository      $roomRepository,
        private readonly GenreRepository     $genreRepository,
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function handleImportForm(FormInterface $form): void
    {
        $file = $form->get('file')->getData();

        $csvData = file_get_contents($file->getPathName());

        $data = $this->serializer->deserialize($csvData, AnimalImportModel::class.'[]', 'csv');
        $genre = $form->get('genre')->getData();
        foreach ($data as $animal)
        {
            if (null === $animal->getChip() || empty($animal->getChip())) {
                continue;
            }

            $found = $this->animalRepository->findOneBy(['chip' => $animal->getChip()]);
            if (null === $found) {
                $found = new Animal();
                $found
                    ->setGuid(GuidGenerator::generate())
                    ->setChip($animal->getChip())
                ;
            }
            $cleanName = preg_replace('/^[A-Za-z0-9\s]+(?=\s)/', '', $animal->getName());
            $cleanRoom = trim(preg_replace('/\.\d+/', '', $animal->getRoom()));

            $room = $this->roomRepository->findOneBy(['code' => $cleanRoom]);

            $found
                ->setName($animal->getName())
                ->setRoom($room)
                ->setColour($animal->getColour())
                ->setGender("5" == $animal->getGender()? "F" : "M")
                ->setGenre($genre)
            ;

          $this->animalRepository->save($found, true);

        }
    }


}