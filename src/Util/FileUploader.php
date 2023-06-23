<?php

namespace App\Util;

use App\Entity\File;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private string $targetDirectory = 'archive';

    public function __construct(
        private SluggerInterface $slugger,
        private LoggerInterface $fileUploaderLogger,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function upload(UploadedFile $uploadedFile): File
    {
        try {
            $file = new File();

            $file->setExtension($uploadedFile->guessExtension());
            $file->setGuid(GuidGenerator::generate());
            $fileName = $file->getGuid() . '.' . $uploadedFile->guessExtension();
            $file->setFilename($fileName);

            $uploadedFile->move($this->targetDirectory, $fileName);
            $this->entityManager->persist($file);
            $this->entityManager->flush();

        } catch (FileException $e) {
            $this->fileUploaderLogger->error($e->getMessage());
        }

        return $file;
    }
}