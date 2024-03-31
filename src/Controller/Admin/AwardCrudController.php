<?php

namespace App\Controller\Admin;

use App\Entity\Award;
use App\Form\Type\AwardTitleType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use Symfony\Component\String\Slugger\AsciiSlugger;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class AwardCrudController extends AbstractCrudController
{
    use Trait\ListYearsTrait;

    public static function getEntityFqcn(): string
    {
        return Award::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des prix')
            ->setEntityLabelInSingular('prix')
            ->setPageTitle('edit', fn (Award $participant) => sprintf('Modifier prix <b>%s</b>', $participant->__toString()))
            ->setPageTitle('new', "Créer prix")
            ->showEntityActionsInlined()
            ->setSearchFields(null)
            ->setFormThemes(['back/award-title-input.html.twig', '@EasyAdmin/crud/form_theme.html.twig']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title', "Titre")->setFormTypeOptions([
                'block_name' => 'custom_title',
                'attr' => ['data-award-title' => null],
            ]),
            ChoiceField::new('year', 'Année du concours')->setChoices($this->generateYears()),
            ChoiceField::new("category", "Type de prix"),
            // CollectionField::new('list_winners', "Vainqueurs")
            //     ->useEntryCrudForm(WinnerCrudController::class),
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

        $slugger = new AsciiSlugger();
        $entityInstance->setSlug($slugger->slug($entityInstance->getTitle()));

        $this->addFlash("success", "<b>Prix {$entityInstance->getTitle()} ({$entityInstance->getYear()})</b> a été crée");

        parent::persistEntity($em, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Award) return;

        foreach ($entityInstance->getListWinners() as $winner) {
            if ($winner->getId() === null) {
                $em->persist($winner);
            }
        }

        $this->addFlash("success", "<b>Prix {$entityInstance->getTitle()} ({$entityInstance->getYear()})</b> a été mis à jour");

        parent::persistEntity($em, $entityInstance);
    }

    public function configureActions(Actions $actions): Actions
    {
        $showAwardPage = Action::new('Voir page')
            ->linkToRoute("awards", function (Award $entity) {
                return [
                    "year" => $entity->getYear(),
                    "category" => $entity->getCategory(),
                    "slug" => $entity->getSlug(),
                ];
            });

        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX, $showAwardPage);
        ;
    }
}
