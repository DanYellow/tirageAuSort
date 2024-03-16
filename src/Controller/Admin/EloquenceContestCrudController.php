<?php

namespace App\Controller\Admin;

use App\Entity\EloquenceContest;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

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
            ChoiceField::new('year', 'Année du concours')->setChoices($this->generateYears()),
            AssociationField::new('participants')->autocomplete(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des concours éloquence')
            ->setEntityLabelInSingular('participant concours éloquence')
            // ->setPageTitle('edit', fn (EloquenceContestParticipant $participant) => sprintf('Modifier <b>%s</b>', $participant->getFullname()))
            ->setPageTitle('new', "Créer un nouveau concours d'éloquence")
            ->showEntityActionsInlined()
            ->setSearchFields(null)
            // ->setEntityPermission('ROLE_EDITOR')
        ;
    }
}
