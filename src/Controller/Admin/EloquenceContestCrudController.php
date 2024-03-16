<?php

namespace App\Controller\Admin;

use App\Entity\EloquenceContest;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EloquenceContestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EloquenceContest::class;
    }

    private function generateYears(): array
    {
        $result = [];

        foreach (range(2023, 2035) as $value) {
            $result[$value] = $value;
        }

        return $result;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ChoiceField::new('year', 'Année de participation')->setChoices($this->generateYears()),,
        ];
    }
}
