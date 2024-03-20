<?php

namespace App\Controller\Admin;

use App\Entity\EloquenceContestParticipant;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

use Doctrine\ORM\EntityManagerInterface;

class EloquenceContestParticipantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EloquenceContestParticipant::class;
    }

    protected EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createEntity(string $entityFqcn): EloquenceContestParticipant
    {
        $entity = parent::createEntity($entityFqcn);
        $entity->setLastname("true");

        return $entity;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstName', 'Prénom')->setColumns(10),
            TextField::new('lastName', 'Nom')->setColumns(10),
            AssociationField::new('formation')->autocomplete()->hideOnIndex()->setColumns(10),
            BooleanField::new("is_active", "Participe au concours ?"),
            // ChoiceField::new('formation', 'Formation'),
            // AssociationField::new('eloquenceContests', "Participe aux concours")->hideOnIndex(),
            // AssociationField::new('eloquenceContests', "Participe aux concours")->hideOnForm()
            //     ->formatValue(function ($value, $entity) {
            //         $str = $entity->getEloquenceContests()[0];
            //         for ($i = 1; $i < $entity->getEloquenceContests()->count(); $i++) {
            //             $str = $str . ", " . $entity->getEloquenceContests()[$i];
            //         }
            //         return $str;
            //     }),

            // BooleanField::new('is_active', "Participe au concours")
            //     ->renderAsSwitch(false)
            //     ->onlyOnForms(),
            // BooleanField::new('is_active', "Participe au concours")->renderAsSwitch(false)->hideOnForm(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste participants - Concours éloquence')
            ->setEntityLabelInSingular('participant concours éloquence')
            ->setPageTitle('edit', fn (EloquenceContestParticipant $participant) => sprintf('Modifier <b>%s</b>', $participant->getFullname()))
            ->setPageTitle('new', "Créer participant au concours d'éloquence")
            ->showEntityActionsInlined()
            ->setSearchFields(null)
            // ->setEntityPermission('ROLE_EDITOR')
        ;
    }
}
