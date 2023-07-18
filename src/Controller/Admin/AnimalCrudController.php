<?php

namespace App\Controller\Admin;

use App\Entity\Animal;
use App\Repository\RoomRepository;
use App\Util\GuidGenerator;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnimalCrudController extends AbstractCrudController
{
    public function __construct(
        private RoomRepository $roomRepository,
    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return Animal::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('admin.animal.singular')
            ->setEntityLabelInPlural('admin.animal.plural')
            ->setEntityPermission("ROLE_ADMIN")
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name','admin.animal.fields.name'),
            TextField::new('chip','admin.animal.fields.chip'),
            ChoiceField::new('gender','admin.animal.fields.gender')->setChoices(['F'=>'F','M'=>'M'])->setRequired(false),
            AssociationField::new('room', 'admin.animal.fields.room')->setQueryBuilder(fn (QueryBuilder $queryBuilder) => $this->roomRepository->createQueryBuilder('r')->orderBy('code','ASC'))->setRequired(false),
            AssociationField::new('genre','admin.animal.fields.genre'),
            DateField::new('birthdayDate','admin.animal.fields.birthday_date'),
            DateField::new('admissionDate','admin.animal.fields.admission_date'),

            ImageField::new('image', 'admin.animal.fields.image')
                ->setBasePath('archive/animal')
                ->setUploadDir('public/archive/animal')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $animal = new Animal();
        $animal->setGuid(GuidGenerator::generate());

        return $animal;
    }
}
