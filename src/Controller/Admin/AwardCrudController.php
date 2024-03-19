<?php

namespace App\Controller\Admin;

use App\Entity\Award;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

use App\EnumTypes\AwardCategory;
use Symfony\Component\Validator\Constraints\Choice;

class AwardCrudController extends AbstractCrudController
{
    use Traits\ListYearsTrait;

    public static function getEntityFqcn(): string
    {
        return Award::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            ChoiceField::new('year', 'Année du concours')->setChoices($this->generateYears()),
            ChoiceField::new("category", "Type de prix")
                ->setChoices(AwardCategory::cases()),
            CollectionField::new('list_winners', "Vainqueurs")->useEntryCrudForm(WinnerCrudController::class),
        ];
    }
}
