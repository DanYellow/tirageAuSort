<?php

namespace App\Form\Type;

use App\Entity\EloquenceContestParticipant;
use App\Entity\EloquenceSubject;
use App\Entity\Formation;
use App\Repository\EloquenceSubjectRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\CallbackTransformer;

class EloquenceContestParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('lastname', TextType::class, [
            'label' => 'Nom de famille',
            "label_html" => true,
            'mapped' => true,
            'help' => 'Champ requis',
            "label_attr" => [
                "class" => "form-control-label required",
            ],
            "attr" => [
                'required' => true,
            ],
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        $builder->add('firstname', TextType::class, [
            'label' => 'Prénom',
            'mapped' => true,
            'help' => 'Champ requis',
            "label_attr" => [
                "class" => "form-control-label required",
            ],
            "attr" => [
                'required' => true,
            ],
            'constraints' => [
                new NotBlank(),
            ],
        ]);
        $builder->add('formation', EntityType::class, [
            'class' => Formation::class,
            'autocomplete' => true,
            'mapped' => true,
            'placeholder' => 'Ne pas préciser',
        ]);
        $builder->add('subject', EntityType::class, [
            'label' => 'Sujet',
            'class' => EloquenceSubject::class,
            'autocomplete' => true,
            'mapped' => true,
            'placeholder' => 'Ne pas préciser',
            'query_builder' => function (EloquenceSubjectRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.year', "DESC")
                    ->addOrderBy('u.title', 'ASC');
            },
            'group_by' => function ($choice, $key, $value): string {
                return is_null($choice->getYear()) ? "Autre" : $choice->getYear();
            },
        ]);
        $builder->add('is_active', ChoiceType::class, [
            'label' => 'Participe au concours ?',
            'required' => false,
            'expanded' => true,
            'mapped' => true,
            'choices' => [
                'Oui' => true,
                'Non' => false,
            ],
            'placeholder' => false,
            'empty_data' => "1",
            'attr' => [
                'data-take-part' => null,
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EloquenceContestParticipant::class,
        ]);
    }

    // public function getBlockPrefix()
    // {
    //     return 'collection_entry_row';
    // }
}
