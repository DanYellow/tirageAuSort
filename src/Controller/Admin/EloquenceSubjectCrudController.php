<?php

namespace App\Controller\Admin;

use App\Entity\EloquenceSubject;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EloquenceSubjectCrudController extends AbstractCrudController
{
    use Trait\ListYearsTrait;

    public static function getEntityFqcn(): string
    {
        return EloquenceSubject::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste sujets concours éloquence')
            ->setEntityLabelInSingular('sujet concours éloquence')
            ->setPageTitle('edit', fn (EloquenceSubject $contest) => sprintf('Modifier sujet "<b>%s</b>"', $contest->getTitle()))
            ->setPageTitle('new', "Créer sujet pour concours d'éloquence")
            ->showEntityActionsInlined()
            ->setSearchFields(null)
        ;
    }


    public function configureFields(string $pageName): iterable
    {
        $list_years = $this->generateYears();
        $list_years["Ne pas préciser"] = null;

        return [
            IdField::new('id')
                ->hideOnForm()
                ->setSortable(false),
            TextField::new('title')
                ->setColumns(7),
            ChoiceField::new('year', 'Année')
                ->setChoices($list_years)
                ->setColumns(7),
        ];
    }
}
