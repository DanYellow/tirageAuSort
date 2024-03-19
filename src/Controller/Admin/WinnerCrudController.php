<?php

namespace App\Controller\Admin;

use App\Entity\Winner;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;


class WinnerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Winner::class;
    }

    // public function configureCrud(): Crud
    // {
    //     return Crud::new()
    //         // ...

    //         // the first argument is the "template name", which is the same as the
    //         // Twig path but without the `@EasyAdmin/` prefix
    //         ->overrideTemplate('label/null', 'admin/labels/my_null_label.html.twig')

    //         ->overrideTemplates([
    //             'crud/index' => 'admin/pages/index.html.twig',
    //             'crud/field/textarea' => 'admin/fields/dynamic_textarea.html.twig',
    //         ])
    //     ;
    // }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname', "Prénom")->setTemplatePath('templates/back/form-winner.html.twig'),
            TextField::new('lastname', "Nom de famille"),
        ];
    }

}
