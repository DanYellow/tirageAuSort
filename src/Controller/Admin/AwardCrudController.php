<?php

namespace App\Controller\Admin;

use App\Controller\AwardsController;
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
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AwardCrudController extends AbstractCrudController
{
    use Trait\ListYearsTrait;

    public static function getEntityFqcn(): string
    {
        return Award::class;
    }

    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
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

    public function edit(AdminContext $context)
    {
        if ($context->getRequest()->query->has('duplicate')) {
            $entity = $context->getEntity()->getInstance();
            /** @var Entity $cloned */
            $cloned = clone $entity;
            $context->getEntity()->setInstance($cloned);
        }

        return parent::edit($context);
    }

    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Award) return;

        foreach ($entityInstance->getListWinners() as $winner) {
            if ($winner->getId() === null) {
                $em->persist($winner);
            }
        }

        $original_id = $entityInstance->getId();

        parent::persistEntity($em, $entityInstance);

        $em->flush();

        if ($entityInstance->getId() === $original_id) {
            // dump($entityInstance->getId());
            // exit;
            // $this->redirectToRoute('awards', [
            //     'entity' => AwardCrudController::getEntityFqcn(),
            //     'action' => 'edit',
            //     'id' => $entityInstance->getId()
            // ]);
            $this->addFlash("success", "<b>Prix {$entityInstance->getTitle()} ({$entityInstance->getYear()})</b> a été mis à jour");
        } else {
        }
    }

    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $url = $this->adminUrlGenerator
            ->setAction(Action::EDIT)
            ->setEntityId($context->getEntity()->getInstance()->getId())
            ->unset("duplicate")
            ->generateUrl();

        return $this->redirect($url);
    }

    protected function redirectToReferrer() {
        
    }

    private function redirectToClonedEntity($id): RedirectResponse
    {
        $url = $this->adminUrlGenerator
            ->setController(AwardsController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        return $this->redirect($url);
        exit;
        return $this->redirectToRoute('awards', [
            'entity' => AwardCrudController::getEntityFqcn(),
            'action' => 'edit',
            'id' => $id
        ]);
    }

    public function configureActions(Actions $actions): Actions
    {
        $showAwardPage = Action::new('Voir page')
            ->setIcon('fa fa-eye')
            ->linkToRoute("awards", function (Award $entity) {
                return [
                    "year" => $entity->getYear(),
                    "category" => $entity->getCategory(),
                    "slug" => $entity->getSlug(),
                ];
            });

        $duplicate = Action::new('Cloner', "Cloner")
            ->setIcon('fa fa-copy')
            ->linkToUrl(
                fn (Award $entity) => $this->adminUrlGenerator
                    ->setAction(Action::EDIT)
                    ->setEntityId($entity->getId())
                    ->set('duplicate', '1')
                    ->generateUrl()
            );

        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX, $showAwardPage)
            ->add(Crud::PAGE_INDEX, $duplicate);;
    }
}
