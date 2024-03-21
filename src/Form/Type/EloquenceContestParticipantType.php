<?php

namespace App\Form\Type;

use App\Entity\EloquenceContestParticipant;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class EloquenceContestParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder->add('id', HiddenType::class);

        $builder->add('lastname', TextType::class, [
            'label' => 'Nom de famille',
            'mapped' => true,
            'required' => true,
        ]);
        $builder->add('firstname', TextType::class, [
            'label' => 'Prénom',
            'mapped' => true,
            'required' => true,
        ]);
        $builder->add('formation', EntityType::class, [
            'class' => Formation::class,
            'autocomplete' => true,
            'placeholder' => 'Choisissez un nom dans la liste',
        ]);
        $builder->add('is_active', CheckboxType::class, [
            'label' => 'Participe au concours ?',
            'empty_data' => true,
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EloquenceContestParticipant::class,
            "allow_extra_fields" => true,
        ]);
    }
}
