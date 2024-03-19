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

    // https://stackoverflow.com/questions/63728259/easyadmin-3-x-how-to-see-related-entities-tostring-instead-of-the-number-of
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ChoiceField::new('year', 'Année du concours')->setChoices($this->generateYears()),
            AssociationField::new('participants')->autocomplete()->hideOnIndex(),
            AssociationField::new('participants', "Participants")
                ->hideOnForm()
                ->formatValue(function ($value, $entity) {
                    $str = $entity->getParticipants()[0];
                    for ($i = 1; $i < $entity->getParticipants()->count(); $i++) {
                        $str = $str . ", " . $entity->getParticipants()[$i];
                    }
                    return $str;
                }),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des concours éloquence')
            ->setEntityLabelInSingular('concours éloquence')
            // ->setPageTitle('edit', fn (EloquenceContestParticipant $participant) => sprintf('Modifier <b>%s</b>', $participant->getFullname()))
            ->setPageTitle('new', "Créer concours d'éloquence")
            ->showEntityActionsInlined()
            ->setSearchFields(null)
            // ->setEntityPermission('ROLE_EDITOR')
        ;
    }
}
