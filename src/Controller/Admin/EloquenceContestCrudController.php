<?php

namespace App\Controller\Admin;

use App\Entity\EloquenceContest;

use App\Entity\EloquenceContestParticipant;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

use Doctrine\ORM\EntityManagerInterface;

use App\Form\Type\EloquenceContestParticipantType;
use App\Form\Field\FileUploadField;


class EloquenceContestCrudController extends AbstractCrudController
{
    use Trait\ListYearsTrait;

    public static function getEntityFqcn(): string
    {
        return EloquenceContest::class;
    }

    // // https://stackoverflow.com/questions/63728259/easyadmin-3-x-how-to-see-related-entities-tostring-instead-of-the-number-of
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->setSortable(false),
            ChoiceField::new('year', 'Année du concours')
                ->setChoices($this->generateYears())
                ->setColumns(8),
            CollectionField::new('participants', "Participants")
                ->hideOnIndex()
                ->setEntryType(EloquenceContestParticipantType::class)->setColumns(8),
            CollectionField::new('participants', "Participants")->hideOnForm()
                ->formatValue(function ($value, $entity) {
                    $activeParticipants = array_filter($entity->getParticipants()->toArray(), function ($item) {
                        return $item->isIsActive();
                    });
                    $nb = count($activeParticipants);
                    $nbTotal = count($entity->getParticipants()->toArray());

                    return "Participants total : {$nbTotal} <br> Participants actifs : {$nb}";
                }),
            FileUploadField::new("file", "Fichier des participants")
                ->setColumns(8)
                ->setHelp("Fichier CSV seulement. Première colonne nom, deuxième colonne prénom")->onlyOnForms()
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des concours éloquence')
            ->setEntityLabelInSingular('concours éloquence')
            ->setPageTitle('edit', fn (EloquenceContest $contest) => sprintf('Modifier <b>concours d\'éloquence %s</b>', $contest->getYear()))
            ->setPageTitle('new', "Créer concours d'éloquence")
            ->showEntityActionsInlined()
            ->setSearchFields(null)
            // ->setEntityPermission('ROLE_EDITOR')
        ;
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof EloquenceContest) return;

        $files = parent::getContext()->getRequest()->files;
        $this->processCSVFile($em, $entityInstance, $files);

        foreach ($entityInstance->getParticipants() as $participant) {
            if ($participant->getId() === null) {
                $em->persist($participant);
            }
        }

        $this->addFlash("success", "<b>Concours d'éloquence {$entityInstance->getYear()}</b> a été crée");

        parent::persistEntity($em, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof EloquenceContest) return;

        $files = parent::getContext()->getRequest()->files;
        $this->processCSVFile($em, $entityInstance, $files);

        foreach ($entityInstance->getParticipants() as $participant) {
            $em->persist($participant);
        }

        $this->addFlash("success", "<b>Concours d'éloquence {$entityInstance->getYear()}</b> a été mis à jour");

        parent::persistEntity($em, $entityInstance);
    }

    private function processCSVFile(EntityManagerInterface $em, $entity, $file): void
    {
        if (!is_null($file->get('EloquenceContest')['file'])) {
            $data_file = $file->get('EloquenceContest')['file'];

            $handle = fopen($data_file->getPathname(), "r");

            while (($data = fgetcsv($handle)) !== false) {
                $participant = new EloquenceContestParticipant();
                $participant->setLastname($data[0]);
                $participant->setFirstname($data[1]);
                $participant->setEloquenceContest($entity);

                $em->persist($participant);
            }
            fclose($handle);
        }
    }
}
