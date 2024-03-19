<?php

namespace App\Controller\Admin;

use App\Entity\Winner;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WinnerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Winner::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname', "Prénom"),
            TextField::new('lastname', "Nom de famille"),
        ];
    }

}
