<?php

namespace App\Controller\Admin;

use App\Entity\Award;
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
use Symfony\Component\HttpFoundation\RequestStack;

use function Symfony\Component\Translation\t;

class AwardCrudController extends AbstractCrudController
{
    use Trait\ListYearsTrait;

    public static function getEntityFqcn(): string
    {
        return Award::class;
    }

    private $adminUrlGenerator;
    private $request;

    public function __construct(AdminUrlGenerator $adminUrlGenerator, RequestStack $requestStack)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->request = $requestStack;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des prix')
            ->setEntityLabelInSingular('prix')
            ->setPageTitle('edit', function (Award $participant) {
                if (parent::getContext()->getRequest()->query->has('is_duplicate')) {
                    return "Créer prix";
                }
                return sprintf('Modifier prix <b>%s</b>', $participant->__toString());
            })
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

        $this->addFlash("success", "<b>Prix {$entityInstance->getCategory()->value} {$entityInstance->getTitle()} ({$entityInstance->getYear()})</b> a été crée");

        parent::persistEntity($em, $entityInstance);
    }

    public function edit(AdminContext $context)
    {
        if ($context->getRequest()->query->has('is_duplicate')) {
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

        if (parent::getContext()->getRequest()->query->has('is_duplicate')) {
            $slugger = new AsciiSlugger();
            $entityInstance->setSlug($slugger->slug($entityInstance->getTitle()));
        }

        parent::persistEntity($em, $entityInstance);

        $em->flush();

        if ($entityInstance->getId() === $original_id) {
            $this->addFlash("success", "<b>Prix {$entityInstance->getCategory()->value} {$entityInstance->getTitle()} ({$entityInstance->getYear()})</b> a été mis à jour");
        }
    }

    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        if (parent::getContext()->getRequest()->query->has('is_duplicate')) {
            $entity = $context->getEntity()->getInstance();
            $this->addFlash("success", "<b>Prix du {$entity->getCategory()->value} {$entity->getTitle()} ({$entity->getYear()})</b> a été crée");
            $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

            $is_save_and_return = $submitButtonName === Action::SAVE_AND_RETURN;
            $url = $this->adminUrlGenerator
                ->setAction($is_save_and_return ? Action::INDEX : Action::NEW)
                ->unset("is_duplicate")
                ->generateUrl();

            return $this->redirect($url);
        }

        return parent::getRedirectResponseAfterSave($context, $action);
    }

    public function configureActions(Actions $actions): Actions
    {
        parent::configureActions($actions);

        $showAwardPage = Action::new('Voir page')
            ->setIcon('fa fa-eye')
            ->linkToRoute("awards", function (Award $entity) {
                return [
                    "year" => $entity->getYear(),
                    "category" => $entity->getCategory(),
                    "slug" => $entity->getSlug(),
                ];
            });

        $duplicate = Action::new('clone', "Cloner")
            ->setIcon('fa fa-copy')
            ->linkToUrl(
                fn (Award $entity) => $this->adminUrlGenerator
                    ->setAction(Action::EDIT)
                    ->setEntityId($entity->getId())
                    ->set('is_duplicate', '1')
                    ->generateUrl()
            );

        return $actions
            ->add(Crud::PAGE_INDEX, $showAwardPage)
            ->add(Crud::PAGE_INDEX, $duplicate)
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                if ($this->request->getCurrentRequest()->query->has('is_duplicate')) {
                    return $action->setLabel(t("action.create", domain: 'EasyAdminBundle'))->setIcon(null);
                }
                return $action;
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                if ($this->request->getCurrentRequest()->query->has('is_duplicate')) {
                    return $action->setLabel(t("action.create_and_add_another", domain: 'EasyAdminBundle'))->setIcon(null);
                }
                return $action;
            });
    }
}
