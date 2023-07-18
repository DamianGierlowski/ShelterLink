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
    private $targetPath;

    public function __construct($uploadPath)
    {
        $this->targetPath = $uploadPath;
    }

    public function upload(UploadedFile $file, $path = null): string
    {
        if (null === $path) {
            $path = $this->targetPath;
        }

        $filename = $this->generateUniqueName($file);

        # Fix the missing image/svg mimetype in Symfony
        if ($file->getMimeType() === "image/svg") {
            $filename .= "svg";
        }

        $file->move($path, $filename);

        return $filename;
    }

    public function generateUniqueName(UploadedFile $file): string
    {
        return md5(uniqid()).".".$file->guessExtension();
    }


//    private string $targetDirectory = 'archive';
//
//    public function __construct(
//        private SluggerInterface $slugger,
//        private LoggerInterface $fileUploaderLogger,
//        private EntityManagerInterface $entityManager,
//    ) {
//    }
//
//    public function upload(UploadedFile $uploadedFile, string $path): File
//    {
//        try {
//            $file = new File();
//
//            $file->setExtension($uploadedFile->guessExtension());
//            $file->setGuid(GuidGenerator::generate());
//            $fileName = $file->getGuid() . '.' . $uploadedFile->guessExtension();
//            $file->setFilename($fileName);
//
//            $uploadedFile->move(
//                $path,
//                $fileName
//            );
//            $this->entityManager->persist($file);
//            $this->entityManager->flush();
//        } catch (FileException $e) {
//            $this->fileUploaderLogger->error($e->getMessage());
//        }
//
//        return $file;
//    }
}