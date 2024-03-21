<?php

namespace App\Form\Type;

use App\Entity\EloquenceContestParticipant;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Test\FormInterface;

class EloquenceContestParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $entity = $builder->getData();

        // $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
        //     $builder = $event->getForm();

        //     $builder->add('lastname', TextType::class, [
        //         'label' => 'Nom de famille *',
        //         "label_html" => true,
        //         'mapped' => true,
        //         'required' => true,
        //         'help' => 'Champ requis',
        //         'constraints' => [
        //             new NotBlank(),
        //         ],
        //     ]);
        //     $builder->add('firstname', TextType::class, [
        //         'label' => 'Prénom',
        //         'mapped' => true,
        //         'required' => true,
        //         'empty_data' => 'John Doe',
        //         'help' => 'Champ requis',
        //         'constraints' => [
        //             new NotBlank(),
        //         ],
        //     ]);
        //     $builder->add('formation', EntityType::class, [
        //         'class' => Formation::class,
        //         'autocomplete' => true,
        //         'mapped' => true,
        //         'placeholder' => 'Choisissez un nom dans la liste',
        //     ]);
        //     $builder->add('is_active', ChoiceType::class, [
        //         'label' => 'Participe au concours ?',
        //         'required' => false,
        //         'expanded' => true,
        //         'choices' => [
        //             'Oui' => true,
        //             'Non' => false,
        //         ],
        //         'placeholder' => false,
        //         // 'data' => true,

        //         // 'data' => is_null($data) ? true : $data->isIsActive(),
        //     ]);
        // });


        $builder->add('lastname', TextType::class, [
            'label' => 'Nom de famille',
            "label_html" => true,
            'mapped' => true,
            'required' => true,
            'help' => 'Champ requis',
            'constraints' => [
                new NotBlank(),
            ],
        ]);
        $builder->add('firstname', TextType::class, [
            'label' => 'Prénom',
            'mapped' => true,
            'required' => true,
            'help' => 'Champ requis',
            'constraints' => [
                new NotBlank([
                    
                ]),
            ],
        ]);
        $builder->add('formation', EntityType::class, [
            'class' => Formation::class,
            'autocomplete' => true,
            'mapped' => true,
            'placeholder' => 'Ne pas préciser',
        ]);
        $builder->add('is_active', ChoiceType::class, [
                'label' => 'Participe au concours ?',
                'required' => false,
                'expanded' => true,
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'placeholder' => false,
                'empty_data' => "1",

                // 'data' => is_null($data) ? true : $data->isIsActive(),
            ]);
        // $builder->add('is_active', CheckboxType::class, [
        //     'label' => 'Participe au concours ?',
        //     'required' => false,

        //     'data' => is_null($data) ? true : $data->isIsActive(),
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // $entity = new EloquenceContestParticipant();
        // $entity->setLastname("true");
        // $entity->setIsActive(true);

        $resolver->setDefaults([
            // 'empty_data' => $entity,
            'data_class' => EloquenceContestParticipant::class,
            'allow_extra_fields' => true,
        ]);
    }
}
