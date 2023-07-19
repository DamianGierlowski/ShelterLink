<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use App\Util\GuidGenerator;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Exception;

class RoomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Room::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('admin.room.singular')
            ->setEntityLabelInPlural('admin.room.plural')
            ->setEntityPermission("ROLE_ADMIN")
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->update(Crud::PAGE_INDEX, Action::DELETE, static function(Action $action) {
                $action->displayIf(static function (Room $room) {
                    // always display, so we can try via the subscriber instead
                    return $room->getIsApproved();
                });

                return $action;
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('code' ,'admin.room.fields.code'),
            BooleanField::new('locked', 'admin.room.fields.locked')
        ];
    }

    public function createEntity(string $entityFqcn)
    {
       $room = new Room();
       $room->setGuid(GuidGenerator::generate());

        return $room;
    }

}
