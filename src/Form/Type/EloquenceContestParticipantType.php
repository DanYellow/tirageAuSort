<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;




class EloquenceContestParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder->add('participants', CollectionType::class, [
        //     // each entry in the array will be an "email" field
        //     'entry_type' => EmailType::class,
        //     // these options are passed to each "email" type
        //     'entry_options' => [
        //         'attr' => ['class' => 'email-box'],
        //     ],
        //     "allow_add" => true,
        //     "allow_delete" => true,
        // ]);

        $builder->add('id', HiddenType::class);

        $builder->add('lastname', TextType::class, [
            'label' => 'Nom de famille',
            'mapped' => false,
            'required' => true,
        ]);
        $builder->add('firstname', TextType::class, [
            'label' => 'Prénom',
            'mapped' => false,
            'required' => true,
        ]);
        $builder->add('is_active', CheckboxType::class, [
            'label' => 'Participe au concours ?',
            'data' => true,
        ]);
        // $builder->add('firstname', TextType::class, [
        //     'label' => 'Image',
        //     'mapped' => false,
        //     'required' => true,
        // ]);
    }
}
