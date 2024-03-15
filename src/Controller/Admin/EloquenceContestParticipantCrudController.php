<?php

namespace App\Controller\Admin;

use App\Entity\EloquenceContestParticipant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EloquenceContestParticipantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EloquenceContestParticipant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstName', 'Prénom'),
            TextField::new('lastName', 'Nom'),
            TextField::new('lastName', 'Nom'),
            TextEditorField::new('descripti/on'),
        ];
    }

}
