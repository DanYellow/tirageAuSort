<?php

namespace App\Controller\Admin;

use App\Entity\Award;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use Symfony\Component\Form\Extension\Core\Type\EnumType;

use App\EnumTypes\AwardCategory;
use Symfony\Component\Validator\Constraints\Choice;

class AwardCrudController extends AbstractCrudController
{
    use Traits\ListYearsTrait;

    public static function getEntityFqcn(): string
    {
        return Award::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des prix')
            ->setEntityLabelInSingular('prix')
            // ->setPageTitle('edit', fn (EloquenceContestParticipant $participant) => sprintf('Modifier <b>%s</b>', $participant->getFullname()))
            ->setPageTitle('new', "Créer prix")
            ->showEntityActionsInlined()
            ->setSearchFields(null)
            // ->setEntityPermission('ROLE_EDITOR')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            ChoiceField::new('year', 'Année du concours')->setChoices($this->generateYears()),
            ChoiceField::new("category", "Type de prix")
                ->setFormType(EnumType::class)
                ->setFormTypeOption("class", AwardCategory::class)
                ->setChoices(AwardCategory::cases()),
            CollectionField::new('list_winners', "Vainqueurs")
                ->useEntryCrudForm(WinnerCrudController::class),
        ];
    }
}
