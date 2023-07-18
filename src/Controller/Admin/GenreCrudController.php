<?php

namespace App\Controller\Admin;

use App\Entity\Genre;
use App\Util\GuidGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GenreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Genre::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('admin.genre.singular')
            ->setEntityLabelInPlural('admin.genre.plural')
            ->setEntityPermission("ROLE_ADMIN")
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name' ,'admin.genre.fields.name'),
            ImageField::new('image', 'admin.genre.fields.image')
                ->setBasePath('archive/genre')
                ->setUploadDir('public/archive/genre')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $genre = new Genre();
        $genre->setGuid(GuidGenerator::generate());


        return $genre;
    }
}
