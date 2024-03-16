<?php

namespace App\Controller\Admin;

use App\Entity\EloquenceContestParticipant;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EloquenceContestParticipantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EloquenceContestParticipant::class;
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
            TextField::new('firstName', 'Prénom'),
            TextField::new('lastName', 'Nom'),
            BooleanField::new('is_active', "Participe au concours")
                ->renderAsSwitch(false)
                ->onlyOnForms(),
            BooleanField::new('is_active', "Participe au concours")->renderAsSwitch(false)->hideOnForm(),
            ChoiceField::new('year', 'Année de participation')->setChoices($this->generateYears()),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste participants concours éloquence')
            ->setEntityLabelInSingular('participant concours éloquence')
            ->setPageTitle('edit', fn (EloquenceContestParticipant $participant) => sprintf('Modifier <b>%s</b>', $participant->getFullname()))
            ->setPageTitle('new', "Créer participant au concours d'éloquence")
            ->showEntityActionsInlined()
            ->setSearchFields(null)
            // ->setEntityPermission('ROLE_EDITOR')
        ;
    }
}
