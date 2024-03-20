<?php

namespace App\Controller\Admin;

use App\Entity\Award;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use Doctrine\ORM\EntityManagerInterface;

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
            // ->setEntityPermission('ROLE_EDITOR') , cascade={"persist"}
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            ChoiceField::new('year', 'Année du concours')->setChoices($this->generateYears()),
            ChoiceField::new("category", "Type de prix"),
            CollectionField::new('list_winners', "Vainqueurs")
                ->useEntryCrudForm(WinnerCrudController::class),
        ];
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Award) return;

        foreach ($entityInstance->getListWinners() as $winner) {
            if ($winner->getId() === null) {
                $em->persist($winner);
            }
        }

        $this->addFlash("success", "<b>{$entityInstance->getTitle()}</b> a été crée");

        parent::persistEntity($em, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Award) return;

        // $list_winners = $entityInstance->getListWinners()->toArray();

        foreach ($entityInstance->getListWinners() as $winner) {
            if ($winner->getId() === null) {
                $em->persist($winner);
            }
        }

        $this->addFlash("success", "<b>{$entityInstance->getTitle()}</b> a été mis à jour");

        parent::persistEntity($em, $entityInstance);
    }
}
